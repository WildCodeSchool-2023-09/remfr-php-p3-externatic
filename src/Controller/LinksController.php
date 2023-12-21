<?php

namespace App\Controller;

use App\Entity\Links;
use App\Form\LinksType;
use App\Repository\LinksRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/links')]
class LinksController extends AbstractController
{
    private Security $security;

    public function __construct(
        Security $security
    ) {
        $this->security = $security;
    }
    #[Route('/', name: 'app_links_index', methods: ['GET'])]
    public function index(LinksRepository $linksRepository): Response
    {
        if (!($this->security->isGranted('ROLE_COLLABORATEUR'))) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('links/index.html.twig', [
            'links' => $linksRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_links_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!($this->security->isGranted('ROLE_COLLABORATEUR'))) {
            return $this->redirectToRoute('app_home');
        }

        $link = new Links();
        $form = $this->createForm(LinksType::class, $link);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($link);
            $entityManager->flush();

            return $this->redirectToRoute('app_links_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('links/new.html.twig', [
            'link' => $link,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_links_show', methods: ['GET'])]
    public function show(Links $link): Response
    {
        if (!($this->security->isGranted('ROLE_COLLABORATEUR'))) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('links/show.html.twig', [
            'link' => $link,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_links_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Links $link, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LinksType::class, $link);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_links_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('links/edit.html.twig', [
            'link' => $link,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_links_delete', methods: ['POST'])]
    public function delete(Request $request, Links $link, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $link->getId(), $request->request->get('_token'))) {
            $entityManager->remove($link);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_links_index', [], Response::HTTP_SEE_OTHER);
    }
}
