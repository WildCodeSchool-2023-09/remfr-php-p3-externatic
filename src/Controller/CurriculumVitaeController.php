<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\CvType;
use App\Entity\Links;
use App\Entity\Skill;
use App\Entity\Language;
use App\Entity\Education;
use App\Entity\Experience;
use App\Entity\CurriculumVitae;
use App\Form\CurriculumVitaeType;
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
        ]);
    }
    /** Créer un CV (en connexion candidat) */
    #[Route('/{id}/userCreateCV', name: 'user_create', methods: ['GET', 'POST'])]
    public function userCreateCV(
        Request $request,
        User $user,
        int $id,
        CurriculumVitae $curriculum,
        EntityManagerInterface $entityManager
    ): Response {
        if (!($this->security->isGranted('ROLE_USER'))) {
            return $this->redirectToRoute('app_home');
        }
        $user = $entityManager->getRepository(User::class)->find($id);
        $cvCollection = new ArrayCollection();
        $form = $this->createForm(CvType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            foreach($curriculum as $curriculumData) {
                $curriculum->addEducation($curriculumData);
                $curriculum->addExperience($curriculumData);
                $curriculum->addLanguage($curriculumData);
                $curriculum->addLink($curriculumData);
                $curriculum->addSkill($curriculumData);
            }

            $entityManager->persist($cvCollection);
            $entityManager->flush();
            return $this->redirectToRoute('user_dashboard', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('curriculum_vitae/candidat/newcv.html.twig', [
            'form' => $form,
            'user' => $user,
        ]);
    }
    // private function education(array $data, EntityManagerInterface $entityManager): void
    // {
    //     foreach ($data as $educationData) {
    //         $education->addName($educationData['name']);
    //         $education->setSchool($educationData['school']);
    //         $education->setCity($educationData['city']);
    //         $education->setBeginDate($educationData['beginDate']);
    //         $education->setEndDate($educationData['endDate']);
    //         $entityManager->persist($education);
    //     }
    // }
    // private function experience(array $experiences, EntityManagerInterface $entityManager): void
    // {
    //     foreach ($experiences as $experienceData) {
    //         $experience = new Experience();
    //         $experience->setName($experienceData['name']);
    //         $entityManager->persist($experience);
    //     }
    // }
    // private function language(array $languages, EntityManagerInterface $entityManager): void
    // {
    //     foreach ($languages as $languageData) {
    //         $language = new Language();
    //         // $languageData->setUser($this->getUser());
    //         $entityManager->persist($language);
    //     }
    // }
    // private function links(array $links, EntityManagerInterface $entityManager): void
    // {
    //     foreach ($links as $linksData) {
    //         $link = new Links();
    //         // $linksData->setUser($this->getUser());
    //         $entityManager->persist($link);
    //     }
    // }
    // private function skills(array $skills, EntityManagerInterface $entityManager): void
    // {
    //     foreach ($skills as $skillsData) {
    //         $skill = new Skill();
    //         // $skillsData->setUser($this->getUser());
    //         $entityManager->persist($skill);
    //     }
    // }
}
