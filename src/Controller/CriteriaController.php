<?php

namespace App\Controller;

use App\Entity\Criteria;
use App\Entity\User;
use App\Form\CriteriaType;
use App\Repository\CriteriaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/criteria', name: 'criteria_')]
class CriteriaController extends AbstractController
{
    private Security $security;

    public function __construct(
        Security $security
    ) {
        $this->security = $security;
    }

    /** Affichage des critères du candidat */
    #[Route('/{id}/index', name: 'index', methods: ['GET'])]
    public function index(
        CriteriaRepository $criteriaRepository,
        Request $request,
        User $user,
        EntityManagerInterface $entityManager
    ): Response {
        if (!($this->security->isGranted('ROLE_USER'))) {
            return $this->redirectToRoute('app_home');
        }

        $criteria = $user->getCriterias();

        return $this->render('criteria/index.html.twig', [
            'criteria' => $criteria,
            'user' => $user,
        ]);
    }

    #[Route('/{id}/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        User $user
    ): Response {
        if (!($this->security->isGranted('ROLE_USER'))) {
            return $this->redirectToRoute('app_home');
        }

        $criteria = new Criteria();
        $criteria->setUser($user);

        $form = $this->createForm(CriteriaType::class, $criteria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($criteria);
            $entityManager->flush();

            return $this->redirectToRoute('criteria_index', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('criteria/new.html.twig', [
            'criteria' => $criteria,
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Criteria $criterion): Response
    {
        if (!($this->security->isGranted('ROLE_USER'))) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('criteria/show.html.twig', [
            'criterion' => $criterion,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Criteria $criteria,
        EntityManagerInterface $entityManager,
    ): Response {
        if (!($this->security->isGranted('ROLE_USER'))) {
            return $this->redirectToRoute('app_home');
        }
        $user = $this->getUser();
        $userId = $user->getId();
        $form = $this->createForm(CriteriaType::class, $criteria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('criteria_index', ['id' => $userId], Response::HTTP_SEE_OTHER);
        }

        return $this->render('criteria/edit.html.twig', [
            'criteria' => $criteria,
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }



    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(
        Request $request,
        Criteria $criterion,
        EntityManagerInterface $entityManager
    ): Response {
        if (!($this->security->isGranted('ROLE_USER'))) {
            return $this->redirectToRoute('app_home');
        }

        if ($this->isCsrfTokenValid('delete' . $criterion->getId(), $request->request->get('_token'))) {
            $entityManager->remove($criterion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('criteria_index', ['id' => $this->getUser()->getId()], Response::HTTP_SEE_OTHER);
    }

    /** Affichage des critères par candidat (en connexion collaborateur) */
    // #[Route('/collaborateurs', name: 'index_collaborateurs', methods: ['GET'])]
    // public function indexCollaborateurs(CriteriaRepository $criteriaRepository): Response
    // {
    //     if (!($this->security->isGranted('ROLE_COLLABORATEUR'))) {
    //         return $this->redirectToRoute('app_home');
    //     }
    //     return $this->render('criteria/index.html.twig', [
    //             'criterias' => $criteriaRepository->findAll(),
    //     ]);
    // }
}
