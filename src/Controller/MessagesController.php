<?php

namespace App\Controller;

use App\Entity\User;
use DateTimeImmutable;
use App\Entity\Messages;
use App\Form\MessagesType;
use Symfony\Component\Mime\Message;
use App\Repository\MessagesRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Notifier\Recipient\Recipient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/messages', name: 'messages_')]
class MessagesController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(MessagesRepository $messagesRepository): Response
    {
        $messages = $messagesRepository->findAll();
        return $this->render('messages/index.html.twig', [
           'messages' => $messages,
        ]);
    }
    #[Route('/send', name: 'send', methods:['GET', 'POST'])]
    public function send(Request $request, EntityManagerInterface $entityManager): Response
    {
        $message = new Messages();
        $form = $this->createForm(MessagesType::class, $message);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message->setSender($this->getUser()) ;
            $message->setCreatedAt(new DateTimeImmutable());

            $entityManager->persist($message);
            $entityManager->flush();

            $this->addFlash("message", "message envoyé avec succès");
            return $this->redirectToRoute("messages_index", [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('messages/send.html.twig', [
            "form" => $form,
            "message" => $message
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

    #[Route('/read/{id}', name: 'read')]
    public function read(Messages $message, EntityManagerInterface $entityManager): Response
    {
        $message->setIsRead(true);
        $entityManager->persist($message);
        $entityManager->flush();

        return $this->render('messages/read.html.twig', [
            'message' => $message
        ]);
    }

    #[Route('/hasRead/{id}', name: 'hasRead')]
    public function hasRead(Messages $message, EntityManagerInterface $entityManager, Request $request): Response
    {

        if ($this->isCsrfTokenValid('read' . $message->getId(), $request->request->get('_token'))) {
            if ($message->isRead() === false) {
                $message->setIsRead(true);
            } else {
                $message->setIsRead(false);
            }
            $entityManager->persist($message);
            $entityManager->flush();
        }
        return $this->redirectToRoute('messages_received', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Messages $message, EntityManagerInterface $entityManager, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete' . $message->getId(), $request->request->get('_token'))) {
            $entityManager->remove($message);
            $entityManager->flush();
        }
        return $this->redirectToRoute('messages_index', [], Response::HTTP_SEE_OTHER);
    }
}
