<?php

namespace App\Controller;

use App\Entity\Country;
use App\Form\CountryFormType;
use App\Repository\CountryRepository;
use App\Repository\RegionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class CountryController extends AbstractController
{
    function __construct(private CountryRepository $countryRepository, private EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->countryRepository = $countryRepository;
    }

    #[Route('/countries', name: 'country_index')]
    public function index(): Response
    {
        $countries = $this->countryRepository->findAll();
        return $this->render('country/index.html.twig', [
            'countries' => $countries,
            'title' => 'Countries'
        ]);
    }

    #[Route('/country/create', name: 'country_create')]
    public function create(): Response
    {
        $country = new Country();
        $countryForm = $this->createForm(CountryFormType::class, $country, ['action' => $this->generateUrl('country_store')]);
        return $this->render(view: 'country/create.html.twig', parameters: ['countryForm' => $countryForm->createView()]);
    }
    #[Route('/country/store', name: 'country_store')]
    public function store(Request $request): Response
    {
        $country = new Country();
        $newCountryForm = $this->createForm(CountryFormType::class, $country);
        $newCountryForm->handleRequest($request);
        if ($newCountryForm->isValid()) {
            $this->em->persist($country);
            $this->em->flush();
            return $this->redirectToRoute(route: 'country_index');
        }
        return $this->render(view: 'country/create.html.twig', parameters: ['countryForm' => $newCountryForm->createView()]);
    }
    #[Route('/country/edit', name: 'country_edit')]
    public function edit(): Response
    {
    }
    #[Route('/country/update', name: 'country_update')]
    public function update(Request $request): Response
    {
    }
}
