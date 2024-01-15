<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Links;
use App\Entity\Skill;
use App\Entity\Language;
use App\Entity\Education;
use App\Entity\Experience;
use App\Entity\CurriculumVitae;
use App\Form\CurriculumVitaeType;
use App\Form\CvType;
use Symfony\Component\DomCrawler\Link;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use App\Repository\CurriculumVitaeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/cv', name: 'cv_')]
class CurriculumVitaeController extends AbstractController
{
    private Security $security;
    public function __construct(
        Security $security
    ) {
        $this->security = $security;
    }
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(CurriculumVitaeRepository $cvRepository): Response
    {
        if (!($this->security->isGranted('ROLE_COLLABORATEUR'))) {
            return $this->redirectToRoute('app_home');
        }
        return $this->render('curriculum_vitae/index.html.twig', [
            'cv' => $cvRepository->findAll(),
        ]);
    }
    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!($this->security->isGranted('ROLE_COLLABORATEUR'))) {
            return $this->redirectToRoute('app_home');
        }
        $curriculum = new CurriculumVitae();
        $form = $this->createForm(CurriculumVitaeType::class, $curriculum);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($curriculum);
            $entityManager->flush();
            return $this->redirectToRoute('cv_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('cv/new.html.twig', [
            'cv' => $curriculum,
            'form' => $form,
        ]);
    }
    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(CurriculumVitae $curriculum): Response
    {
        if (!($this->security->isGranted('ROLE_COLLABORATEUR'))) {
            return $this->redirectToRoute('app_home');
        }
        return $this->render('cv/show.html.twig', [
            'cv' => $curriculum,
        ]);
    }
    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        CurriculumVitae $curriculum,
        EntityManagerInterface $entityManager
    ): Response {
        if (!($this->security->isGranted('ROLE_COLLABORATEUR'))) {
            return $this->redirectToRoute('app_home');
        }
        $form = $this->createForm(CurriculumVitaeType::class, $curriculum);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('cv_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('cv/edit.html.twig', [
            'cv' => $curriculum,
            'form' => $form,
        ]);
    }
    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(
        Request $request,
        CurriculumVitae $curriculum,
        EntityManagerInterface $entityManager
    ): Response {
        if (!($this->security->isGranted('ROLE_COLLABORATEUR'))) {
            return $this->redirectToRoute('app_home');
        }
        if ($this->isCsrfTokenValid('delete' . $curriculum->getId(), $request->request->get('_token'))) {
            $entityManager->remove($curriculum);
            $entityManager->flush();
        }
        return $this->redirectToRoute('cv_index', [], Response::HTTP_SEE_OTHER);
    }
    /** Accès au CV (en connexion candidat) */
    #[Route('/{id}/userCV', name: 'user_cv', methods: ['GET', 'POST'])]
    public function userCurriculum(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $curriculum = $user->getCurriculum();
        if (!$curriculum) {
            $curriculum = new CurriculumVitae();
            $curriculum->setUsers($user);
        }
        $form = $this->createForm(CurriculumVitaeType::class, $curriculum);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($curriculum);
            $entityManager->flush();
            return $this->redirectToRoute('user_dashboard', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('curriculum_vitae/candidat/moncv.html.twig', [
            'curriculum' => $curriculum,
            'form' => $form,
            'user' => $user,
        ]);
    }
    /** Créer un CV (en connexion candidat) */
    #[Route('/{id}/userCreateCV', name: 'user_create', methods: ['GET', 'POST'])]
    public function userCreateCV(
        Request $request,
        User $user,
        int $id,
        EntityManagerInterface $entityManager
    ): Response {

        if (!($this->security->isGranted('ROLE_USER'))) {
            return $this->redirectToRoute('app_home');
        }
        $user = $entityManager->getRepository(User::class)->find($id);
        $form = $this->createForm(CvType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** Créer et persister le CV */
            $curriculumVitaes = $form->getData();
            $curriculumVitaes->setUsers($this->getUser());
            $entityManager->persist($curriculumVitaes);

            /** Créer et persister les formations */
            $educations = $form->get('educations')->getData();
            foreach ($educations as $education) {
                $curriculumVitaes->addEducation($education);
                $entityManager->persist($education);
            }

            /** Créer et persister les expériences pro */
            $experiences = $form->get('experiences')->getData();
            foreach ($experiences as $experience) {
                $curriculumVitaes->addExperience($experience);
                $entityManager->persist($experience);
            }

            /** Créer et persister les langues */
            $languages = $form->get('languages')->getData();
            foreach ($languages as $language) {
                $curriculumVitaes->addLanguage($language);
                $entityManager->persist($language);
            }

            /** Créer et persister les liens */
            $links = $form->get('links')->getData();
            foreach ($links as $link) {
                $curriculumVitaes->addLink($link);
                $entityManager->persist($link);
            }

            /** Créer et persister les skills */
            $skills = $form->get('skills')->getData();
            foreach ($skills as $skill) {
                $curriculumVitaes->addSkill($skill);
                $entityManager->persist($skill);
            }
            $entityManager->persist($curriculumVitaes);
            $entityManager->flush();
            return $this->redirectToRoute('user_dashboard', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('curriculum_vitae/candidat/newcv.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }
}
