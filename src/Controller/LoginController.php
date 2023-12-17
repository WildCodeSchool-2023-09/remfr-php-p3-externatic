<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
/** connexion d'un utilisateur */
    #[Route('/connexion', name: 'connexion', methods:['GET'])]
    public function login(): Response
    {
        $form = $this->createForm(LoginType::class);

        return $this->render('users/connexion.html.twig', [
            'connexion' => $form
        ]);
    }

    /** Sécurisation du login */
    #[Route('/login_check', name: 'login_check', methods:['POST'])]
    public function check(Request $request): Response
    {

        $form = $this->createForm(LoginType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            //$login = $form->getData();

            // ... perform some action, such as saving the task to the database
            // TODO : Redirect to correct route
            return $this->redirectToRoute('task_success');
        }

        // TODO : Render correct template
        return $this->render('task/new.html.twig', [
            'form' => $form,
        ]);
    }
}
