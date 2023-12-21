<?php

namespace App\Controller;

use App\Entity\Criteria;
use App\Form\CriteriaType;
use App\Repository\CriteriaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/criteria', name: 'experience_')]
class CriteriaController extends AbstractController
{
    private Security $security;

    public function __construct(
        Security $security
    ) {
        $this->security = $security;
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(CriteriaRepository $criteriaRepository): Response
    {
        if (!($this->security->isGranted('ROLE_COLLABORATEUR'))) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('criteria/index.html.twig', [
            'criterias' => $criteriaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_criteria_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $criterion = new Criteria();
        $form = $this->createForm(CriteriaType::class, $criterion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($criterion);
            $entityManager->flush();

            return $this->redirectToRoute('app_criteria_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('criteria/new.html.twig', [
            'criterion' => $criterion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_criteria_show', methods: ['GET'])]
    public function show(Criteria $criterion): Response
    {
        return $this->render('criteria/show.html.twig', [
            'criterion' => $criterion,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_criteria_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Criteria $criterion, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CriteriaType::class, $criterion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_criteria_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('criteria/edit.html.twig', [
            'criterion' => $criterion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_criteria_delete', methods: ['POST'])]
    public function delete(Request $request, Criteria $criterion, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $criterion->getId(), $request->request->get('_token'))) {
            $entityManager->remove($criterion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_criteria_index', [], Response::HTTP_SEE_OTHER);
    }
}
