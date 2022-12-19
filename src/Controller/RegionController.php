<?php

namespace App\Controller;

use App\Entity\Region;
use App\Repository\RegionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegionController extends AbstractController
{
    function __construct(private RegionRepository $regionRepository, private EntityManagerInterface $em)
    {
        $this->regionRepository = $regionRepository;
        $this->em = $em;
    }
    #[Route('/regions', name: 'region_index')]
    public function index(): Response
    {
    }
    #[Route(path: '/region/create', name: 'region_create')]
    public function create(): Response
    {
    }
    #[Route(path: '/region/details/{id}', name: 'region_show')]
    public function show($id): Response
    {
        $region = $this->regionRepository->find($id);
        return $this->render(view: 'region/show.html.twig', parameters: ['region' => $region]);
    }
}
