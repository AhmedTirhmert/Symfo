<?php

namespace App\Controller;

use App\Entity\City;
use App\Form\CityFormType;
use App\Repository\CityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CityController extends AbstractController
{
    function __construct(private CityRepository $cityRepository, private EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->cityRepository = $cityRepository;
    }

    #[Route('/cities', name: 'city_index')]
    public function index(): Response
    {

        // $this->cityRepository->updateCities();

        $cities = $this->cityRepository->findAll();
        return $this->render('city/index.html.twig', [
            'cities' => $cities,
            'title' => 'Cities'
        ]);
    }

    #[Route('/city/create', name: 'city_create')]
    public function create(): Response
    {
        $city = new City();
        $cityForm = $this->createForm(CityFormType::class, $city, ['action' => $this->generateUrl('city_store')]);
        return $this->render(view: 'city/create.html.twig', parameters: ['cityForm' => $cityForm->createView()]);
    }
    #[Route('/city/store', name: 'city_store')]
    public function store(Request $request): Response
    {
        $city = new City();
        $newCityForm = $this->createForm(CityFormType::class, $city);
        $newCityForm->handleRequest($request);
        if ($newCityForm->isValid()) {
            $this->em->persist($city);
            $this->em->flush();
            return $this->redirectToRoute(route: 'city_index');
        }
        return $this->render(view: 'city/create.html.twig', parameters: ['cityForm' => $newCityForm->createView()]);
    }
    #[Route('/city/edit', name: 'city_edit')]
    public function edit(): Response
    {
    }
    #[Route('/city/update', name: 'city_update')]
    public function update(Request $request): Response
    {
    }


    #[Route('/city/show/{id}', name: 'city_show')]
    public function show($id): Response
    {
        $city = $this->cityRepository->find($id);
        return $this->render(view: 'city/show.html.twig', parameters: ['city' => $city]);
    }
}
