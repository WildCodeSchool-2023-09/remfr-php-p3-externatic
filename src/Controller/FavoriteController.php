<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/favorites', name: 'favorites_')]
class FavoriteController extends AbstractController
{
    #[Route('/add/{offer_id}', name: 'apply', methods:['GET'])]
    public function favorite(
        Request $request,
        EntityManagerInterface $entityManager,
        #[MapEntity(mapping: ['offer_id' => 'id'])] Offer $offer
    ): Response {
        $user = $this->getUser();
        $user->addFavorite($offer);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('offer_public_detail', ['id' => $offer->getId()]);
    }
}
