<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Jobs;
use App\Form\ContactFormType;
use App\Repository\ArticleRepository;
use App\Repository\JobsRepository;
use App\Repository\ProfilRepository;
use App\Repository\ProjectRepository;
use App\Repository\SpotlightRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;

class SiteController extends AbstractController
{
    /**
     * *page pricipale
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
    public function association(ProfilRepository $repoProfil): Response
    {
        $profil = $repoProfil->findAll();
        return $this->render('site/association.html.twig', [
            'page_name' => 'Association',
            'profil' => $profil,
        ]);
    }

    /**
     * *affichage des projets
     * @Route("/projets", name="projets")
     */
    public function projets(ProjectRepository $repoProjects): Response
    {
        $projects = $repoProjects->findAll();
        return $this->render('site/projets.html.twig', [
            'page_name' => 'Projets',
            'projects' => $projects,
        ]);
    }


    /**
     * *affichage des jobs sous forme de card
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
     * *affichage complet des jobs
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
     * affichage des article du blog sous forme de card
     * @Route("/blog", name="blog")
     */
    public function blog(ArticleRepository $repoArticle): Response
    {
        $articles = $repoArticle->findAll();
        return $this->render('site/blog.html.twig', [
            'page_name' => 'Blog',
            'articles' => $articles,

        ]);
    }


    /**
     * *affichage complet des articles
     * @Route("/blog/{id}", name="show_blog")
     */
    public function show_blog(Article $article, SpotlightRepository $repoSpot): Response
    {
        return $this->render('site/showBlog.html.twig', [
            'page_name' => 'Blog',
            'article' => $article,
        ]);
    }

    /**
     * *fonction de suppression de job
     * @Route("/event/{id}/delete", name="delete_jobs")
     */
    public function deleteArticle(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $article = $entityManager->getRepository(Article::class)->find($id);
        $entityManager->remove($article);
        $entityManager->flush();

        return $this->redirectToRoute("blog");
    }


    /**
     * *page de contact pour TedyWare
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        // $contact = new Contact();
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $name = $form['name']->getData();
            $mail = $form['mail']->getData();
            $messageContent = $form['message']->getData();
            $phone = $form['phone']->getData();
            $type = $form['contactType']->getData();



            $message = (new Email())

                ->from($mail)
                ->to('contact@tedyware.fr')
                ->subject($type)
                ->html(
                    '<strong> Nom(s) / Entreprise : </strong>' . $name . '<br>' .
                        '<strong>Email : </strong>' . '<a target"_blank" href="mailto:' . $mail . '">' . $mail . '</a>' . '<br>' .
                        '<strong>Téléphone : </strong>' . '<a target"_blank" href="tel:' . $phone . '">' . $phone . '</a>'   . '<br>' .
                        '<strong>Type de la demande : </strong>' . $type . '<br>' . '<br>' .
                        '<strong>Contenu du message : </strong>' . $messageContent,
                    'text/html'
                );
            $mailer->send($message);

            $this->addFlash('success', 'Votre mail a bien été envoyé !');
            return $this->redirectToRoute('contact');
        }
        return $this->render('site/contact.html.twig', [
            'page_name' => 'Contact',
            'formContact' => $form->createView(),
        ]);
    }
    /**
     * *affichage des mentions
     * @Route("/mentions", name="mentions")
     */
    public function mentions(): Response
    {

        return $this->render('site/mentions.html.twig', [
            'page_name' => 'Mentions Légales',
        ]);
    }
}
