<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Category;
use App\Entity\Jobs;
use App\Entity\Profil;
use App\Entity\Project;
use App\Entity\Spotlight;
use App\Repository\ArticleRepository;
use App\Repository\JobsRepository;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard/", name="dashboard")
     */
    public function index(): Response
    {
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'page_name' => 'Dashboard',
        ]);
    }



    /**
     * +Les Articles
     */

    /**
     * *formulaire de creation et modification des articles
     * @Route("/dashboard/article/{id}/edit", name="edit_article")
     * @Route("/dashboard/article/new", name="create_article")
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
     * *fonction de suppression d'article
     * @Route("dashboard/user/{id}/delete", name="delete_article")
     */
    public function deleteArticle(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $articles = $entityManager->getRepository(Article::class)->find($id);
        $entityManager->remove($articles);
        $entityManager->flush();

        return $this->redirectToRoute("dashboard_article");
    }


    /**
     * @Route("/dashboard/article", name="dashboard_articles")
     */
    public function article(ArticleRepository $repoArticle): Response
    {
        $articles = $repoArticle->findAll();
        return $this->render('dashboard/article.html.twig', [
            'page_name' => 'Blog',
            'articles' => $articles,
        ]);
    }


    /**
     * +Les jobs
     */
    /**
     * *formulaire de creation et modification de job
     * @Route("/dashboard/jobs/{id}/edit", name="edit_jobs")
     * @Route("/dashboard/jobs/new", name="create_jobs")
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
     * *fonction de suppression de job
     * @Route("/dashboard/jobs/{id}/delete", name="delete_jobs")
     */
    public function deleteJobs(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $jobs = $entityManager->getRepository(Jobs::class)->find($id);
        $entityManager->remove($jobs);
        $entityManager->flush();

        return $this->redirectToRoute("blog");
    }

    /**
     * *affichage complet des jobs
     * @Route("/dashboard/jobs", name="dashboard_jobs")
     */
    public function jobs(JobsRepository $repoJobs): Response
    {
        $jobs = $repoJobs->findAll();

        return $this->render('dashboard/jobs.html.twig', [
            'page_name' => 'Jobs',
            'jobs' => $jobs,
        ]);
    }

    /**
     * *formulaire de creation et modification de projet terminer
     * @Route("/dashboard/projects/{id}/edit", name="edit_projects")
     * @Route("/dashboard/projects/new", name="create_projects")
     */
    public function formProjects(Project $projects = null, Request $request, EntityManagerInterface $manager)
    {

        if (!$projects) {
            $projects = new Project();
        }

        $form = $this->createFormBuilder($projects)
            ->add('collaborator')
            ->add('name')
            ->add('type')
            ->add('picture')
            ->add('completionDate')
            ->add('description')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($projects);
            $manager->flush();
            return $this->redirectToRoute('show_projects', ['id' => $projects->getId()]);
        }

        return $this->render('site/createProject.html.twig', [
            'page_name' => 'Ajouter un Project',
            'formProject' => $form->createView(),
            'editMode' => $projects->getId() !== null,
        ]);
    }

    /**
     * *fonction de suppression de projets
     * @Route("/dashboard/projects/{id}/delete", name="delete_projects")
     */
    public function deleteProject(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $project = $entityManager->getRepository(Project::class)->find($id);
        $entityManager->remove($project);
        $entityManager->flush();

        return $this->redirectToRoute("dashboard_project_off");
    }
    /**
     * *affichage des projets
     * @Route("/dashboard/projectComplete", name="dashboard_project_off")
     */
    public function projets(ProjectRepository $repoProjects): Response
    {
        $projects = $repoProjects->findAll();
        return $this->render('dashboard/projectComplete.html.twig', [
            'page_name' => 'Projets terminés',
            'projects' => $projects,
        ]);
    }

    /**
     * *affichage des projets
     * @Route("/dashboard/infos", name="dashboard_infos")
     */
    public function info(): Response
    {
        return $this->render('dashboard/informations.html.twig', [
            'page_name' => 'Projets terminés',
        ]);
    }
}
