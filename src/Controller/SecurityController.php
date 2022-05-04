<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Role;
use App\Repository\UserRepository;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{

    /**
     * +Les Utilisateurs
     */
    /**
     * *formulaire de creation et modification des user
     * @Route("/dashboard/user/{id}/edit", name="edit_user")
     * @Route("/dashboard/user/new", name="create_user")
     */
    public function formUser(User $user = null, Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $encoder)
    {
        if (!$user) {
            $user = new User();
        }
        $formUser = $this->createFormBuilder($user)
            ->add('email')
            ->add('username')
            ->add('password', PasswordType::class, [
                'help' => 'Le mot de passe doit contenir entre 8 et 50 caractere.',
            ])
            ->add('confirm_password', PasswordType::class)
            ->add('role', EntityType::class, [
                'class' => Role::class,
                'label' => 'Role de l\'utilisateur'
            ])
            ->getForm();
        $formUser->handleRequest($request);
        dump($formUser);
        if ($formUser->isSubmitted() && $formUser->isValid()) {
            $hash = $encoder->hashPassword($user, $user->getPassword());
            $user->setPassword($hash);
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('dashboard_user');
        }
        return $this->render('security/registration.html.twig', [
            'page_name' => 'Ajouter un User',
            'formUser' => $formUser->createView(),
            'editMode' => $user->getId() !== null,
        ]);
    }

    /**
     * *fonction de suppression d'utilisateur
     * @Route("dashboard/user/{id}/delete", name="delete_user")
     */
    public function deleteUser(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);
        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute("dashboard_user");
    }

    /**
     * @Route ("/dashboard/user", name="dashboard_user")
     */
    public function add(UserRepository $repoUser): Response
    {
        $user = $repoUser->findAll();

        return $this->render('dashboard/user.html.twig', [
            'page_name' => 'Crée, Modifier, Supprimer...',
            'user' => $user,
        ]);
    }

    /**
     * @Route ("/connexion", name="security_login")
     */
    public function login()
    {
        return $this->render('security/login.html.twig', [
            'page_name' => 'Login',

        ]);
    }

    /**
     * @Route ("/deconnexion", name="security_logout")
     */
    public function logout()
    {
    }
}
