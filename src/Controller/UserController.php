<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    function __construct(private UserRepository $userRepository, private EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->em = $entityManager;
    }

    #[Route('/users', name: 'user_index')]
    public function index(): Response
    {
        $users = $this->userRepository->findAll();
        // dd($users);
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }
    #[Route(path: '/user/create', name: 'user_create')]
    public function create(): Response
    {
        $user = new User();
        // dd($this->getUser());
        $userForm = $this->createForm(type: UserFormType::class, data: $user, options: ['action' => $this->generateUrl('user_store')]);
        return $this->render('user/create.html.twig', [
            'userForm' => $userForm->createView()
        ]);
    }


    #[Route(path: '/user/store', name: 'user_store')]
    public function store(Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = new User();
        $newUserForm = $this->createForm(UserFormType::class, $user);
        $newUserForm->handleRequest($request);
        if ($newUserForm->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $newUserForm->get('password')->getData()
                )
            );
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            return $this->redirectToRoute('user_index');
        }
        return $this->render(view: 'user/create.html.twig', parameters: ['userForm' => $newUserForm->createView()]);
    }
}
