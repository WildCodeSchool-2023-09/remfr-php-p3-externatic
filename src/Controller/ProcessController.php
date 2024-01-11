<?php

namespace App\Controller;

use DateTimeImmutable;
use App\Entity\Offer;
use App\Entity\Process;
use App\Form\ProcessPublicType;
use App\Form\ProcessType;
use App\Repository\OfferRepository;
use App\Repository\ProcessRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
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

    #[Route('/list', name: 'list', methods: ['GET'])]
    public function list(ProcessRepository $processRepository): Response
    {
        if (!($this->security->isGranted('ROLE_USER'))) {
            return $this->redirectToRoute('app_home');
        }

        $user = $this->getUser();

        return $this->render('process_public/list.html.twig', [
            'processes' => $user->getProcess(),
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
            $now = new DateTimeImmutable();
            $process->setCreatedAt($now);
            $process->setUpdatedAt($now);

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
            'process' => $process,
            'form' => $form,
        ]);
    }

    #[Route('/public/{id}/edit', name: 'public_edit', methods: ['GET', 'POST'])]
    public function publicEdit(Request $request, Process $process, EntityManagerInterface $entityManager): Response
    {
        if (!($this->security->isGranted('ROLE_USER'))) {
            return $this->redirectToRoute('app_home');
        }

        $form = $this->createForm(ProcessPublicType::class, $process);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('process_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('process_public/edit.html.twig', [
            'process' => $process,
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

    #[Route('/public/{id}', name: 'public_delete', methods: ['POST'])]
    public function publicDelete(Request $request, Process $process, EntityManagerInterface $entityManager): Response
    {
        if (!($this->security->isGranted('ROLE_USER'))) {
            return $this->redirectToRoute('app_home');
        }

        if ($this->isCsrfTokenValid('delete' . $process->getId(), $request->request->get('_token'))) {
            $entityManager->remove($process);
            $entityManager->flush();
        }
        return $this->redirectToRoute('process_list', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/apply/{offer_id}', name: 'apply', methods: ['GET'])]
    public function applyToJob(
        Request $request,
        EntityManagerInterface $entityManager,
        #[MapEntity(mapping: ['offer_id' => 'id'])] Offer $offer
    ): Response {

        if (!($this->security->isGranted('ROLE_USER'))) {
            return $this->redirectToRoute('app_home');
        }

        $newProcess = new Process();

        $user = $this->getUser();
        $collaborator = $user->getCollaborateur();

        $now = new DateTimeImmutable();
        $newProcess->setCreatedAt($now);
        $newProcess->setUpdatedAt($now);

        $newProcess->setUser($user);
        $newProcess->setCollaborateur($collaborator);
        $newProcess->setOffer($offer);

        $newProcess->setProcess(1);
        $newProcess->setStatut(1);

        $entityManager->persist($newProcess);
        $entityManager->flush();

        return $this->render('process_public/confirm.html.twig');
    }
}
