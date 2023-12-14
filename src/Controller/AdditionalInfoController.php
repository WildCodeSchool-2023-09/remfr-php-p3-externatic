<?php

namespace App\Controller;

use App\Entity\AdditionalInfo;
use App\Form\AdditionalInfoType;
use App\Repository\AdditionalInfoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/additional/info')]
class AdditionalInfoController extends AbstractController
{
    #[Route('/', name: 'app_additional_info_index', methods: ['GET'])]
    public function index(AdditionalInfoRepository $infoRepository): Response
    {
        return $this->render('additional_info/index.html.twig', [
            'additional_infos' => $infoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_additional_info_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $additionalInfo = new AdditionalInfo();
        $form = $this->createForm(AdditionalInfoType::class, $additionalInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($additionalInfo);
            $entityManager->flush();

            return $this->redirectToRoute('app_additional_info_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('additional_info/new.html.twig', [
            'additional_info' => $additionalInfo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_additional_info_show', methods: ['GET'])]
    public function show(AdditionalInfo $additionalInfo): Response
    {
        return $this->render('additional_info/show.html.twig', [
            'additional_info' => $additionalInfo,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_additional_info_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        AdditionalInfo $additionalInfo,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(AdditionalInfoType::class, $additionalInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_additional_info_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('additional_info/edit.html.twig', [
            'additional_info' => $additionalInfo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_additional_info_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        AdditionalInfo $additionalInfo,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $additionalInfo->getId(), $request->request->get('_token'))) {
            $entityManager->remove($additionalInfo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_additional_info_index', [], Response::HTTP_SEE_OTHER);
    }
}
