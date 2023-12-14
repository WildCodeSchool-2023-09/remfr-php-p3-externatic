<?php

namespace App\Controller;

use App\Entity\Users;
use App\Repository\UsersRepository;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    /** Afficher tous les utilisateurs */

    #[Route('/', name: 'app_user_index', methods:['GET'])]
    public function index(UsersRepository $usersRepository): Response
    {
        $users = $usersRepository->findAll();
        return $this->render('users/index.html.twig', ['users' => $users]);
    }

    /** Créer un nouvel utilisateur */

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new USERS();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('users/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /** Afficher un utilisateur */

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(Users $user): Response
    {
        return $this->render('users/show.html.twig', [
            'user' => $user,
        ]);
    }

    /** Editer un utilisateur */

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Users $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('users/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /** Supprimer un utilisateur */

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, Users $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
