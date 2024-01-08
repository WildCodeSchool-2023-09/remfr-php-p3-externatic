<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\UserType;
use App\Form\UserRolesType;
use App\Form\LoginType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user', name: 'user_')]
class UserController extends AbstractController
{
    private Security $security;
    /** Afficher tous les utilisateurs */

    public function __construct(
        Security $security
    ) {
        $this->security = $security;
    }

    #[Route('/', name: 'index', methods:['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        if (!($this->security->isGranted('ROLE_ADMIN'))) {
            return $this->redirectToRoute('app_home');
        }
            $users = $userRepository->findAll();
            return $this->render('user/index.html.twig', ['users' => $users]);
    }

    /** Créer un nouvel utilisateur */

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
    ): Response {
        if (!($this->security->isGranted('ROLE_ADMIN'))) {
            return $this->redirectToRoute('app_home');
        }

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /** Afficher un utilisateur */

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(User $user): Response
    {
        if (!($this->security->isGranted('ROLE_ADMIN'))) {
            return $this->redirectToRoute('app_home');
        }
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /** Editer un utilisateur */

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        User $user,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        if (!($this->security->isGranted('ROLE_ADMIN'))) {
            return $this->redirectToRoute('app_home');
        }
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /** Supprimer un utilisateur */

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if (!($this->security->isGranted('ROLE_ADMIN'))) {
            return $this->redirectToRoute('app_home');
        }
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }

    /** Modification des rôles d'un utilisateur */
    #[Route('/roles/{id}', name: 'roles', methods:['GET', 'POST'])]
    public function roles(
        UserRepository $userRepository,
        Request $request,
        User $user,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(UserRolesType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/roles.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /** Accès aux données personnelles (en connexion candidat) */

    #[Route('/{id}/editUser', name: 'edit_user', methods: ['GET', 'POST'])]
    public function editUser(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $currentUser = $this->getUser(); // Récupérer l'utilisateur actuellement connecté

        // Vérifier si l'utilisateur connecté est autorisé à modifier les données
        if ($currentUser !== $user) {
            throw $this->createAccessDeniedException("Vous n'êtes pas autorisé à modifier ces données.");
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('user_edit_user', ['id' => $user->getId()]);
            // Redirection vers la page de profil mise à jour
        }

        return $this->render('user_public/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /** Supprimer son compte en tant qu'utilisateur */

    #[Route('/delete/{id}', name: 'delete_user', methods: ['POST'])]
    public function deleteUser(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        //On récupère l'utilisateur actuellement connecté
        $currentUser = $this->security->getUser();

        // On vérifie si l'utilisateur connecté est celui dont le compte est supprimé
        if (
            $currentUser === $user && $this->isCsrfTokenValid(
                'delete' . $user->getId(),
                $request->request->get('_token')
            )
        ) {
            $entityManager->remove($user);
            $entityManager->flush();

        // On redirige vers la page login
            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
        }
        // Redirection si l'utilisateur n'est pas autorisé à supprimer ce compte
        return $this->redirectToRoute('app_home');
    }
}
