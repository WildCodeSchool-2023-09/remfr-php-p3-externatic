<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Form\MessagesType;
use App\Repository\MessagesRepository;
use Symfony\Component\Mime\Message;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Notifier\Recipient\Recipient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MessagesController extends AbstractController
{
    #[Route('/messages', name: 'messages')]
    public function index(MessagesRepository $messagesRepository): Response
    {
        $user = $this->getUser();
        $message = $messagesRepository->findAll();
        return $this->render('messages/index.html.twig', [
            //'recipient' => $recipient,
            //'sender' => $sender,
        ]);
    }
    #[Route('/send', name: 'send')]
    public function send(Request $request): Response
    {
        $message = new Messages();
        $form = $this->createForm(MessagesType::class, $message);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message->setSender($this->getUser()) ;

            $em = $this->$this->getDoctrine()->getManager();
            $em->persist($message);
            $em->fluch();

            $this->addFlash("message", "message envoyé avec succès");
            return $this->redirectToRoute("messages");
        }

        return $this->render('messages/send.html.twig', [
            "form" => $form->createView()
        ]);
    }

    #[Route('/received', name: 'received')]
    public function received(): Response
    {
        return $this->render('messages/received.html.twig');
    }


    #[Route('/sent', name: 'sent')]
    public function sent(): Response
    {
        return $this->render('messages/sent.html.twig');
    }

    #[Route('/read', name: 'read')]
    public function read(Messages $message): Response
    {
        $message->setRead(true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($message);
        $em->flush();

        return $this->render('messages/read.html.twig', compact("message"));
    }

    #[Route('/delete', name: 'read')]
    public function delete(Messages $message): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($message);
        $em->flush();

        return $this->redirectToRoute("received");
    }
}
