<?php

namespace App\Controller;

use App\Entity\Jobs;
use App\Repository\JobsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('site/index.html.twig', [
            'page_name' => 'Accueil',
        ]);
    }

    /**
     * @Route("/association", name="association")
     */
    public function association(): Response
    {
        return $this->render('site/association.html.twig', [
            'page_name' => 'Association',
        ]);
    }

    /**
     * @Route("/projets", name="projets")
     */
    public function projets(): Response
    {
        return $this->render('site/projets.html.twig', [
            'page_name' => 'Projets',
        ]);
    }


    /**
     * affichage des jobs sous forme de card
     * @Route("/jobs", name="jobs")
     */
    public function jobs(JobsRepository $repoJobs): Response
    {
        $jobs = $repoJobs->findAll();
        return $this->render('site/jobs.html.twig', [
            'page_name' => 'Jobs',
            'jobs' => $jobs,

        ]);
    }

    /**
     * formulaire de creation et modification de job
     * @Route("/jobs/{id}/edit", name="edit_jobs")
     * @Route("/jobs/new", name="create_jobs")
     */
    public function formJobs(Jobs $jobs = null, Request $request, EntityManagerInterface $manager)
    {

        if (!$jobs) {
            $jobs = new Jobs();
        }

        $form = $this->createFormBuilder($jobs)
            ->add('title')
            ->add('picture')
            ->add('content', CKEditorType::class)
            ->add('mission', CKEditorType::class)
            ->add('technologie', CKEditorType::class)
            ->add('search_profile', CKEditorType::class)
            ->add('contract')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($jobs->getId()) {
                $jobs->setCreatedAt(new \DateTime);
            }

            $manager->persist($jobs);
            $manager->flush();
            return $this->redirectToRoute('show_jobs', ['id' => $jobs->getId()]);
        }

        return $this->render('site/createJobs.html.twig', [
            'page_name' => 'Ajouter un Jobs',
            'formJobs' => $form->createView(),
            'editMode' => $jobs->getId() !== null,
        ]);
    }

    /**
     * affichage complet des jobs
     * @Route("/jobs/{id}", name="show_jobs")
     */
    public function show_jobs(Jobs $jobs): Response
    {

        return $this->render('site/showJobs.html.twig', [
            'page_name' => 'Jobs',
            'jobs' => $jobs,
        ]);
    }

    /**
     * fonction de suppression de job
     * @Route("/event/{id}/delete", name="delete_jobs")
     */
    public function deleteEvent(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $jobs = $entityManager->getRepository(Jobs::class)->find($id);
        $entityManager->remove($jobs);
        $entityManager->flush();

        return $this->redirectToRoute("jobs");
    }



    /**
     * @Route("/contact", name="contact")
     */
    public function contact(): Response
    {
        return $this->render('site/contact.html.twig', [
            'page_name' => 'Contact',
        ]);
    }
}
