<?php

namespace App\Controller;

use App\Entity\Player;
use App\Form\PlayerFormType;
use App\Repository\PlayerRepository;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlayerController extends AbstractController
{

    function __construct(private PlayerRepository $playerRepository,private EntityManagerInterface $entityManager,private TeamRepository $teamRepository)
    {
        $this->playerRepository = $playerRepository;
        $this->teamRepository = $teamRepository;
        $this->em = $entityManager;
    }


    #[Route('/players', name: 'player_index')]
    public function index(): Response
    {
        $players = $this->playerRepository->findBy([], ['id' => 'DESC'], 15, 0);
        // dd($players[0]->getTeamId());
        return $this->render('player/index.html.twig', ['players' => $players]);
    }


    #[Route('/player/create', name: 'player_create')]
    public function create(): Response
    {
        $player = new Player();
        $playerForm = $this->createForm(PlayerFormType::class, $player, ['action' => $this->generateUrl('player_store')]);

        return $this->render('player/create.html.twig', [
            'playerForm' => $playerForm->createView()
        ]);
    }


    #[Route('/player/store', name: 'player_store')]
    public function store(Request $request): Response
    {
        $player = new Player();
        $team = $this->teamRepository->find($request->get('player_form')['team']);
        $newPlayerForm = $this->createForm(PlayerFormType::class, $player);
        $newPlayerForm->handleRequest($request);
        if ($newPlayerForm->isValid()) {
            $player->setTeamId($team);
            $player->setFifaApiId(rand(min: 1, max: 10000));
            $player->setPlayerApiId(rand(min: 1, max: 10000));
            $this->em->persist($player);
            $this->em->flush();
            return $this->redirectToRoute('player_index');
        }

        return $this->render('player/create.html.twig', [
            'playerForm' => $newPlayerForm->createView()
        ]);
    }


    #[Route('/player/edit/{id}', name: 'player_edit')]
    public function edit(int $id, Request $request): Response
    {
        $player = $this->playerRepository->find($id);

        $playerForm = $this->createForm(PlayerFormType::class,  $player);

        return $this->render('player/edit.html.twig', [
            'playerForm' => $playerForm->createView()
        ]);
    }


    #[Route('/player/update', name: 'player_update')]
    public function update(Request $request): Response
    {
        $id = $request->get('player_form')['id'];
        $player = $this->playerRepository->find($id);
        $playerForm = $this->createForm(PlayerFormType::class, $player);
        $playerForm->handleRequest($request);

        if ($playerForm->isValid() && $playerForm->isValid()) {
            $this->em->persist($player);
            $this->em->flush();
            return $this->redirectToRoute('player_index');
        }
        return $this->render('player/edit.html.twig', [
            'playerForm' => $playerForm->createView()
        ]);
    }
}
