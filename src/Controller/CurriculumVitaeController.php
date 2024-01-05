<?php

namespace App\Controller;

use App\Entity\CurriculumVitae;
use App\Entity\User;
use App\Form\CurriculumVitaeType;
use App\Form\CvType;
use App\Repository\CurriculumVitaeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/cv', name: 'cv_')]
class CurriculumVitaeController extends AbstractController
{
    private Security $security;

    public function __construct(
        Security $security
    ) {
        $this->security = $security;
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(CurriculumVitaeRepository $cvRepository): Response
    {
        if (!($this->security->isGranted('ROLE_COLLABORATEUR'))) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('curriculum_vitae/index.html.twig', [
            'cv' => $cvRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!($this->security->isGranted('ROLE_COLLABORATEUR'))) {
            return $this->redirectToRoute('app_home');
        }

        $curriculum = new CurriculumVitae();
        $form = $this->createForm(CurriculumVitaeType::class, $curriculum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($curriculum);
            $entityManager->flush();

            return $this->redirectToRoute('cv_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cv/new.html.twig', [
            'cv' => $curriculum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(CurriculumVitae $curriculum): Response
    {
        if (!($this->security->isGranted('ROLE_COLLABORATEUR'))) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('cv/show.html.twig', [
            'cv' => $curriculum,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        CurriculumVitae $curriculum,
        EntityManagerInterface $entityManager
    ): Response {
        if (!($this->security->isGranted('ROLE_COLLABORATEUR'))) {
            return $this->redirectToRoute('app_home');
        }

        $form = $this->createForm(CurriculumVitaeType::class, $curriculum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('cv_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cv/edit.html.twig', [
            'cv' => $curriculum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(
        Request $request,
        CurriculumVitae $curriculum,
        EntityManagerInterface $entityManager
    ): Response {
        if (!($this->security->isGranted('ROLE_COLLABORATEUR'))) {
            return $this->redirectToRoute('app_home');
        }

        if ($this->isCsrfTokenValid('delete' . $curriculum->getId(), $request->request->get('_token'))) {
            $entityManager->remove($curriculum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cv_index', [], Response::HTTP_SEE_OTHER);
    }

    /** Accès au CV (en connexion candidat) */

    #[Route('/{id}/userCV', name: 'user_cv', methods: ['GET', 'POST'])]
    public function userCurriculum(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $curriculum = $user->getCurriculum();
        if (!$curriculum) {
            $curriculum = new CurriculumVitae();
            $curriculum->setUsers($user);
        }

        $form = $this->createForm(CurriculumVitaeType::class, $curriculum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($curriculum);
            $entityManager->flush();

            return $this->redirectToRoute('user_dashboard', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('curriculum_vitae/candidat/moncv.html.twig', [
            'curriculum' => $curriculum,
            'form' => $form,
        ]);
    }

    /** Créer un CV (en connexion candidat) */

    #[Route('/{id}/userCreateCV', name: 'user_create', methods: ['GET', 'POST'])]
    public function userCreateCV(Request $request, User $user, int $id, EntityManagerInterface $entityManager): Response
    {
        $user = $entityManager->getRepository(User::class)->find($id);

        $form = $this->createForm(CvType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('user_dashboard', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('curriculum_vitae/candidat/newcv.html.twig', [
            'form' => $form,
            'user' => $user,
        ]);
    }
}
