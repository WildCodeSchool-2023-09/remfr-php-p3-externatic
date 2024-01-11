<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/static', name: 'static_')]
class StaticController extends AbstractController
{
    #[Route('/ml', name: 'ml')]
    public function ml(): Response
    {
        return $this->render('static/ml.html.twig');
    }

    #[Route('/cgu', name: 'cgu')]
    public function cgu(): Response
    {
        return $this->render('static/cgu.html.twig');
    }

    #[Route('/cookies', name: 'cookies')]
    public function cookies(): Response
    {
        return $this->render('static/cookies.html.twig');
    }
}
