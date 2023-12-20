<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

#[Route('/admin', name: 'admin_')]
class AdminDashboardController extends AbstractController
{
    #[Route('/', name: 'dashboard', methods:['GET'])]
    public function index(): Response
    {
        // Vérifie si l'utilisateur est connecté et a le rôle d'administrateur (admin)
        if ($this->getUser() && in_array('ROLE_ADMIN', $this->getUser()->getRoles(), true)) {
            // Si l'utilisateur est un admin, affiche le tableau de bord de l'admin
            return $this->render('admin/dashboard.html.twig');
        } else {
            // Si l'utilisateur n'est pas un admin, redirection vers la page d'accueil
            return $this->redirectToRoute('home/index.html.twig');
        }
    }
}
