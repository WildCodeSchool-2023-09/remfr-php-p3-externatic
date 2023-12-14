<?php

namespace App\Controller;

use App\Entity\CurriculumVitae;
use App\Form\CurriculumVitaeType;
use App\Repository\CurriculumVitaeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/curriculum/vitae')]
class CurriculumVitaeController extends AbstractController
{
    #[Route('/', name: 'app_curriculum_vitae_index', methods: ['GET'])]
    public function index(CurriculumVitaeRepository $cvRepository): Response
    {
        return $this->render('curriculum_vitae/index.html.twig', [
            'curriculum_vitaes' => $cvRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_curriculum_vitae_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $curriculumVitae = new CurriculumVitae();
        $form = $this->createForm(CurriculumVitaeType::class, $curriculumVitae);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($curriculumVitae);
            $entityManager->flush();

            return $this->redirectToRoute('app_curriculum_vitae_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('curriculum_vitae/new.html.twig', [
            'curriculum_vitae' => $curriculumVitae,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_curriculum_vitae_show', methods: ['GET'])]
    public function show(CurriculumVitae $curriculumVitae): Response
    {
        return $this->render('curriculum_vitae/show.html.twig', [
            'curriculum_vitae' => $curriculumVitae,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_curriculum_vitae_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        CurriculumVitae $curriculumVitae,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(CurriculumVitaeType::class, $curriculumVitae);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_curriculum_vitae_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('curriculum_vitae/edit.html.twig', [
            'curriculum_vitae' => $curriculumVitae,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_curriculum_vitae_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        CurriculumVitae $curriculumVitae,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $curriculumVitae->getId(), $request->request->get('_token'))) {
            $entityManager->remove($curriculumVitae);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_curriculum_vitae_index', [], Response::HTTP_SEE_OTHER);
    }
}