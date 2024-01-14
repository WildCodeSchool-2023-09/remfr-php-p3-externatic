<?php

namespace App\Service;

use App\Entity\Criteria;
use App\Entity\Offer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class AlertService
{
    private MailerInterface $mailer;
    private EntityManagerInterface $entityManager;

    public function __construct(
        MailerInterface $mailer,
        EntityManagerInterface $entityManager
    ) {
        $this->mailer = $mailer;
        $this->entityManager = $entityManager;
    }

    public function checkForAlerts(Offer $offer): bool
    {
        $criteriaRepo = $this->entityManager->getRepository(Criteria::class);

        $matchingCriteria = $criteriaRepo->findMatchingCriteria($offer);

        foreach ($matchingCriteria as $criterion) {
            $user = $criterion->getUser();

            $user->setNotificationWaiting(true);

            $this->entityManager->persist($user);

            $email = (new Email())
                ->from('your_email@example.com')
                ->to($user->getEmail())
                ->subject('Une nouvelle offre vient d\'être publiée !')
                ->html('<p>Une nouvelle offre correspondant à vos critères vient d\'être publiée sur Externatic !</p>');

            $this->mailer->send($email);
        }

        $this->entityManager->flush();

        return true;
    }
}
