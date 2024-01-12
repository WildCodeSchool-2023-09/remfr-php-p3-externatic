<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/favorites', name: 'favorites_')]
class FavoriteController extends AbstractController
{
    private Security $security;
    /** Afficher tous les utilisateurs */

    public function __construct(
        Security $security
    ) {
        $this->security = $security;
    }

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

    #[Route('/list', name: 'list', methods:['GET'])]
    public function offerFavorite(
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response {
        if (!($this->security->isGranted('ROLE_USER'))) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('offer_public/favorites.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/remove/{offer_id}', name: 'remove', methods:['GET'])]
    public function remove(
        Request $request,
        EntityManagerInterface $entityManager,
        #[MapEntity(mapping: ['offer_id' => 'id'])] Offer $offer
    ): Response {
        $user = $this->getUser();
        $user->removeFavorite($offer);

        $entityManager->persist($user);
        $entityManager->flush();

        if ($_GET["from"] == "list") {
            return $this->redirectToRoute('favorites_list');
        }
        return $this->redirectToRoute('offer_public_detail', ['id' => $offer->getId()]);
    }
}
