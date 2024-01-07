<?php

namespace App\Controller;

use App\Entity\Process;
use App\Form\ProcessType;
use App\Repository\ProcessRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/process', name: 'process_')]
class ProcessController extends AbstractController
{
    private Security $security;

    public function __construct(
        Security $security
    ) {
        $this->security = $security;
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(ProcessRepository $processRepository): Response
    {
        if (!($this->security->isGranted('ROLE_COLLABORATEUR'))) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('process/index.html.twig', [
            'processes' => $processRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!($this->security->isGranted('ROLE_COLLABORATEUR'))) {
            return $this->redirectToRoute('app_home');
        }

        $process = new Process();
        $form = $this->createForm(ProcessType::class, $process);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($process);
            $entityManager->flush();

            return $this->redirectToRoute('process_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('process/new.html.twig', [
            'processes' => $process,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Process $process): Response
    {
        if (!($this->security->isGranted('ROLE_COLLABORATEUR'))) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('process/show.html.twig', [
            'process' => $process,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Process $process, EntityManagerInterface $entityManager): Response
    {
        if (!($this->security->isGranted('ROLE_COLLABORATEUR'))) {
            return $this->redirectToRoute('app_home');
        }

        $form = $this->createForm(ProcessType::class, $process);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('process_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('process/edit.html.twig', [
            'processes' => $process,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Process $process, EntityManagerInterface $entityManager): Response
    {
        if (!($this->security->isGranted('ROLE_COLLABORATEUR'))) {
            return $this->redirectToRoute('app_home');
        }

        if ($this->isCsrfTokenValid('delete' . $process->getId(), $request->request->get('_token'))) {
            $entityManager->remove($process);
            $entityManager->flush();
        }

        return $this->redirectToRoute('process_index', [], Response::HTTP_SEE_OTHER);
    }
}
