<?php

namespace App\Controller;

use App\Entity\League;
use App\Form\LeagueFormType;
use App\Repository\LeagueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LeagueController extends AbstractController
{

    function __construct(private LeagueRepository $leagueRepository, private EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->leagueRepository = $leagueRepository;
    }

    #[Route('/leagues', name: 'league_index')]
    public function index(): Response
    {
        $leagues = $this->leagueRepository->findAll();
        return $this->render('league/index.html.twig', [
            'leagues' => $leagues,
            'title' => 'Leagues'
        ]);
    }

    #[Route('/league/create', name: 'league_create')]
    public function create(): Response
    {
        $league = new League();
        $leagueForm = $this->createForm(LeagueFormType::class, $league, ['action' => $this->generateUrl('league_store')]);
        return $this->render(view: 'league/create.html.twig', parameters: ['leagueForm' => $leagueForm->createView(), 'title' => 'Create League']);
    }
    #[Route('/league/store', name: 'league_store')]
    public function store(Request $request): Response
    {
        $league = new League();
        $newLeagueForm = $this->createForm(LeagueFormType::class, $league);
        $newLeagueForm->handleRequest($request);
        if ($newLeagueForm->isValid()) {
            $this->em->persist($league);
            $this->em->flush();
            return $this->redirectToRoute(route: 'league_index');
        }
        return $this->render(view: 'league/create.html.twig', parameters: ['leagueForm' => $newLeagueForm->createView(), 'title' => 'Create League']);
    }
    #[Route('/league/edit/{id}', name: 'league_edit')]
    public function edit($id): Response
    {
        $league = $this->leagueRepository->find($id);
        $leagueForm = $this->createForm(LeagueFormType::class, $league, ['action' => $this->generateUrl(route: 'league_update', parameters: ['id' => $id])]);
        return $this->render(view: 'league/edit.html.twig', parameters: ['leagueForm' => $leagueForm->createView(), 'title' => 'Update League']);
    }
    #[Route('/league/update', name: 'league_update')]
    public function update(Request $request): Response
    {
        $id = $request->get('id');
        $league = $this->leagueRepository->find($id);
        $updatedLeagueForm = $this->createForm(LeagueFormType::class, $league);
        $updatedLeagueForm->handleRequest($request);
        if ($updatedLeagueForm->isValid()) {
            $league->setUpdatedAt();
            $this->em->persist($league);
            $this->em->flush();
            return $this->redirectToRoute(route: 'league_index');
        }
        return $this->render(view: 'league/edit.html.twig', parameters: ['leagueForm' => $updatedLeagueForm->createView(), 'title' => 'Update League']);
    }
}
