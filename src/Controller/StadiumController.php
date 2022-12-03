<?php

namespace App\Controller;

use App\Entity\Stadium;
use App\Form\StadiumFormType;
use App\Repository\StadiumRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StadiumController extends AbstractController
{
    function __construct(private StadiumRepository $stadiumRepository, private EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->stadiumRepository = $stadiumRepository;
    }

    #[Route('/stadiums', name: 'stadium_index')]
    public function index(): Response
    {
        $stadiums = $this->stadiumRepository->findBy(orderBy:['capacity' => 'DESC'],criteria:[]);
        return $this->render('stadium/index.html.twig', [
            'stadiums' => $stadiums,
            'title' => 'stadiums'
        ]);
    }

    #[Route('/stadium/create', name: 'stadium_create')]
    public function create(): Response
    {
        $stadium = new Stadium();
        $stadiumForm = $this->createForm(StadiumFormType::class, $stadium, ['action' => $this->generateUrl('stadium_store')]);
        return $this->render(view: 'stadium/create.html.twig', parameters: ['stadiumForm' => $stadiumForm->createView(), 'title' => 'Create Stadium']);
    }
    #[Route('/stadium/store', name: 'stadium_store')]
    public function store(Request $request): Response
    {
    }
    #[Route('/stadium/edit', name: 'stadium_edit')]
    public function edit(): Response
    {
    }
    #[Route('/stadium/update', name: 'stadium_update')]
    public function update(Request $request): Response
    {
    }
}
