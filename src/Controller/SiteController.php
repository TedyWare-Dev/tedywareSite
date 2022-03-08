<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
     * @Route("/jobs", name="jobs")
     */
    public function jobs(): Response
    {
        return $this->render('site/jobs.html.twig', [
            'page_name' => 'Jobs',
        ]);
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
