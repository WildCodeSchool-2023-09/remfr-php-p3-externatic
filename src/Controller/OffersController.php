<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class OffersController extends AbstractController
{
    #[Route('/offers/', name: 'offers_index')]
    public function index(): Response
    {
        return $this->render('offers/index.html.twig', [
            'offre' => 'Ce que contient la clé offre.',
         ]);
    }

    #[Route('/offers2/', name: 'offers2_index')]
    public function index2(): Response
    {
        return $this->render('offers/index2.html.twig', [
            'offre' => 'Ce que contient la clé offre.',
         ]);
    }
}
