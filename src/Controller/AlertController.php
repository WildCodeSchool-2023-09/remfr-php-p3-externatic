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

#[Route('/alerts', name: 'alerts_')]
class AlertController extends AbstractController
{
}
