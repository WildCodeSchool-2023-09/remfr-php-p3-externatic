<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\UserType;
use App\Form\UserEditType;
use App\Form\UserRolesType;
use App\Form\LoginType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
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
            return $this->render('user/index.html.twig', [
                'users' => $users,
                'type' => 'utilisateurs'
            ]);
    }

    /** Afficher tous les candidats (user n'ayant que le rôle USER */
    #[Route('/candidates', name: 'candidates', methods:['GET'])]
    public function candidates(UserRepository $userRepository): Response
    {
        if (!($this->security->isGranted('ROLE_COLLABORATEUR'))) {
            return $this->redirectToRoute('app_home');
        }
        $users = $userRepository->findAll();

        foreach ($users as $k => $user) {
            if ($user->hasRole('ROLE_COLLABORATEUR') || $user->hasRole('ROLE_ADMIN')) {
                unset($users[$k]);
            }
        }

        return $this->render('user/index.html.twig', [
            'users' => $users,
            'type' => 'candidats'
        ]);
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
        } elseif ($form->isSubmitted()) {
            dd($form->getErrors(true));
        }
        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /** Supprimer un utilisateur (côté admin) */

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(
        Request $request,
        User $user,
        EntityManagerInterface $entityManager,
        UserRepository $userRepo,
    ): Response {
        if (!($this->security->isGranted('ROLE_ADMIN'))) {
            return $this->redirectToRoute('app_home');
        }
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $user->setRoles(['ROLE_USER']);
            $entityManager->persist($user);
            $entityManager->flush();

            $users = $userRepo->findAll();
            foreach ($users as $k => $collaborateur) {
                if (!($collaborateur->hasRole('ROLE_ADMIN') || $collaborateur->hasRole('ROLE_COLLABORATEUR'))) {
                    unset($users[$k]);
                }
            }

                $collaborateur = $users[array_rand($users)];

            $processes = $user->getProcess();

            foreach ($processes as $process) {
                $entityManager->remove($process);
            }
            $processes = $user->getProcesses();

            foreach ($processes as $process) {
                $process->setCollaborateur($collaborateur);

                $entityManager->persist($process);
            }
            $candidates = $user->getCandidates();

            foreach ($candidates as $candidate) {
                $candidate->setCollaborateur($collaborateur);
            }

            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }

    /** Supprimer un utilisateur */

    #[Route('/public/{id}', name: 'pubdelete', methods: ['POST'])]
    public function publicDelete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if (!($this->security->isGranted('ROLE_USER'))) {
            return $this->redirectToRoute('app_home');
        }
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $processes = $user->getProcess();

            foreach ($processes as $process) {
                $entityManager->remove($process);
            }

            $entityManager->remove($user);
            $entityManager->flush();

            // Logout l'utilisateur sans CSRF
            $this->security->logout(false);
        }

        return $this->redirectToRoute('app_home');
    }

    /** Accès aux données personnelles (en connexion candidat) */

    #[Route('/{id}/editUser', name: 'edit_user', methods: ['GET', 'POST'])]
    public function editUser(
        Request $request,
        User $user,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        MailerInterface $mailer,
    ): Response {
        $form = $this->createForm(UserEditType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $collaborateur = $user->getCollaborateur();

            $entityManager->persist($user);
            $entityManager->flush();

            /** Informer le collaborateur que l'utilisateur a modifié des informations sur son profil */
            $email = (new Email())
            ->from('updates@externatic.com')
            ->to($collaborateur->getEmail())
            ->subject('Un candidat a mis ses informations à jour !')
            ->html('<p>L\'utilisateur ' . $user->getFullname() . ' a mis ses informations à jour !</p>');

            $mailer->send($email);

            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user_public/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
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
}
