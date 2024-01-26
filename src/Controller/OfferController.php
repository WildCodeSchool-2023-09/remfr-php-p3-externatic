<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Entity\User;
use App\Entity\Criteria;
use App\Form\OfferType;
use App\Repository\OfferRepository;
use App\Service\AlertService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CriteriaRepository;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/offer', name: 'offer_')]
class OfferController extends AbstractController
{
    private Security $security;

    public function __construct(
        Security $security
    ) {
        $this->security = $security;
    }

    #[Route('/', name: 'index', methods: ['GET', 'POST'])]
    public function index(
        OfferRepository $offerRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        if (!($this->security->isGranted('ROLE_COLLABORATEUR'))) {
            return $this->redirectToRoute('app_home');
        }
        $form = $this->createFormBuilder(null, [
            'method' => 'get'
        ])
            ->add(child:'search', type: SearchType::class)
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->get('search')->getData();
            $query = $offerRepository->findLikeName($search);
        } else {
            $query = $offerRepository->queryfindAll();
        }
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('offer/index.html.twig', [
            'offers' => $pagination,
            'form' => $form,
        ]);
    }

    #[Route('/public/', name: 'public_list', methods: ['GET'])]
    public function publicList(
        OfferRepository $offerRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $form = $this->createFormBuilder(null, [
            'method' => 'get'
        ])
            ->add(child:'search', type: SearchType::class)
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->get('search')->getData();
            $query = $offerRepository->findLikeName($search);
        } else {
            $query = $offerRepository->queryfindAll();
        }

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), /*page number*/
            9 /*limit per page*/
        );

        return $this->render('offer_public/list.html.twig', [
            'offers' => $pagination,
            'form' => $form,
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        AlertService $alert
    ): Response {
        if (!($this->security->isGranted('ROLE_COLLABORATEUR'))) {
            return $this->redirectToRoute('app_home');
        }

        $offer = new Offer();
        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($offer);

            $entityManager->flush();

            $alert->checkForAlerts($offer);

            return $this->redirectToRoute('offer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('offer/new.html.twig', [
            'offer' => $offer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Offer $offer): Response
    {
        if (!($this->security->isGranted('ROLE_COLLABORATEUR'))) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('offer/show.html.twig', [
            'offer' => $offer,
        ]);
    }

    #[Route('/public/{id}', name: 'public_detail', methods: ['GET'])]
    public function publicDetail(Offer $offer): Response
    {
        if (!($this->security->isGranted('ROLE_USER'))) {
            return $this->redirectToRoute('app_login');
        }

        $user = $this->getUser();
        $isFavorited = $user->getFavorites()->contains($offer);

        return $this->render('offer_public/detail.html.twig', [
            'offer' => $offer,
            'isFavorited' => $isFavorited,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Offer $offer, EntityManagerInterface $entityManager): Response
    {
        if (!($this->security->isGranted('ROLE_COLLABORATEUR'))) {
            return $this->redirectToRoute('app_home');
        }

        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('offer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('offer/edit.html.twig', [
            'offer' => $offer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Offer $offer, EntityManagerInterface $entityManager): Response
    {
        if (!($this->security->isGranted('ROLE_COLLABORATEUR'))) {
            return $this->redirectToRoute('app_home');
        }

        if ($this->isCsrfTokenValid('delete' . $offer->getId(), $request->request->get('_token'))) {
            $entityManager->remove($offer);
            $processes = $offer->getProcess();

            foreach ($processes as $process) {
                $entityManager->remove($process);
            }

            $entityManager->flush();
        }

        return $this->redirectToRoute('offer_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/user_offer', name: 'user_offer', methods: ['GET'])]
    public function userOffer(
        OfferRepository $offerRepository,
        CriteriaRepository $criteriaRepository,
        User $user,
        EntityManagerInterface $entityManager
    ): Response {
        if (!($this->security->isGranted('ROLE_USER'))) {
            return $this->redirectToRoute('app_home');
        }

        // Récupère les critères du candidat connecté
        $userCriteria = $user->getCriterias();

        $matchingOffers = [];
        $appliedJobs = [];
        $offersToShow = [];
        if (!($userCriteria->isEmpty())) {
            // Récupère les offres correspondant aux critères du candidat
            $matchingOffers = $offerRepository->findMatchingCriteria($userCriteria);
            $appliedProcesses = $user -> getProcess();
            foreach ($appliedProcesses as $process) {
                $appliedJobs[] = $process ->getOffer();
            }
            $offersToShow = array_diff($matchingOffers, $appliedJobs);
        }

        $user->setNotificationWaiting(false);
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->render('offer/user_offer.html.twig', [
            'offers' => $offersToShow,
        ]);
    }
}
