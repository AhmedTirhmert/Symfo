<?php

namespace App\Controller;

use App\Entity\Team;
use App\Form\TeamFormType;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class TeamController extends AbstractController
{

    function __construct(private TeamRepository $teamrepository, private EntityManagerInterface $em)
    {
        $this->teamrepository = $teamrepository;
        $this->em = $em;
    }

    #[Route('/teams', name: 'team_index')]
    public function index(): Response
    {
        $teams = $this->teamrepository->findAll();
        return $this->render('team/index.html.twig', ['teams' => $teams]);
    }

    #[Route(path: 'team/create', name: 'team_create')]
    public function create(): Response
    {
        $team = new Team();
        $teamForm = $this->createForm(TeamFormType::class, $team, ['action' => $this->generateUrl('team_store')]);
        return $this->render('team/create.html.twig', [
            'teamForm' => $teamForm->createView(),
            'title' => 'Create Team'
        ]);
    }

    #[Route(path: 'api/team/create')]
    public function apiCreate(): Response
    {
        $newTeamForm = $this->createForm(TeamFormType::class);
        $view = $this->renderView(view: 'team/create.html.twig', parameters: ['teamForm' => $newTeamForm->createView(), 'title' => 'Create Team', 'template' => false]);
        return $this->json([
            'form' => $view,
        ], 200);
    }
    #[Route(path: 'team/store', name: 'team_store')]
    public function store(Request $request): Response
    {
        $team = new Team();
        $newTeamForm = $this->createForm(TeamFormType::class, $team);
        $newTeamForm->handleRequest($request);
        if ($newTeamForm->isValid()) {
            $this->em->persist($team);
            $this->em->flush();
            return $this->redirectToRoute('team_index');
        }
        return $this->render(view: 'team/create.html.twig', parameters: ['teamForm' => $newTeamForm->createView()]);
    }



    #[Route(path: 'api/team/store')]
    public function apiStore(Request $request): Response
    {
        $team = new Team();
        $newTeamForm = $this->createForm(TeamFormType::class, $team);
        $newTeamForm->handleRequest($request);
        if ($newTeamForm->isValid()) {
            $this->em->persist($team);
            $this->em->flush();
            return $this->json([
                'message' => 'Team Created Successfully'
            ], 200);
        }

        $view = $this->renderView(view: 'team/create.html.twig', parameters: ['teamForm' => $newTeamForm->createView(), 'title' => 'Create Team', 'template' => false]);
        return $this->json([
            'form' => $view,
        ], 500);
    }
}
