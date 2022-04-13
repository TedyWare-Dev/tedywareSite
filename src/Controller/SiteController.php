<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Contact;
use App\Entity\Jobs;
use App\Entity\Profil;
use App\Entity\Spotlight;
use App\Form\ContactFormType;
use App\Notification\ContactNotification;
use App\Repository\ArticleRepository;
use App\Repository\JobsRepository;
use App\Repository\ProfilRepository;
use App\Repository\ProjectRepository;
use App\Repository\SpotlightRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
     * *formulaire de creation et modification de job
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
     * *fonction de suppression de job
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
     * *formulaire de creation et modification des articles
     * @Route("/blog/{id}/edit", name="edit_article")
     * @Route("/blog/new", name="create_article")
     */
    public function formBlog(Article $article = null, Request $request, EntityManagerInterface $manager)
    {

        if (!$article) {
            $article = new Article();
        }

        $formArticle = $this->createFormBuilder($article)
            ->add('title')
            ->add('pictureArticle')
            ->add('paragraphe', CKEditorType::class)
            ->add('category', EntityType::class, [
                'class' => Category::class
            ])
            ->add('author', EntityType::class, [
                'class' => Profil::class
            ])
            ->add('Spotlight', EntityType::class, [
                'class' => Spotlight::class
            ])


            ->getForm();
        $formArticle->handleRequest($request);
        dump($formArticle);
        if ($formArticle->isSubmitted() && $formArticle->isValid()) {

            $article->setCreatedAt(new \DateTime());
            // if ($article->getId()) {
            // }

            $manager->persist($article);
            $manager->flush();
            return $this->redirectToRoute('show_blog', ['id' => $article->getId()]);
        }

        return $this->render('site/createArticle.html.twig', [
            'page_name' => 'Ajouter un Article',
            'formArticle' => $formArticle->createView(),
            'editMode' => $article->getId() !== null,
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
     * TODO make a contact part
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
     * *affichage des jobs sous forme de card
     * @Route("/mentions", name="mentions")
     */
    public function mentions(): Response
    {
        
        return $this->render('site/mentions.html.twig', [
            'page_name' => 'Mentions Légales',
        ]);
    }
}
