<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security as SecurityBundle;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils, Request $request, UserPasswordHasherInterface $passwordEncoder): Response
    {
        $title = 'Connexion - Login';
        // Get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // Last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $user = new User();
        $form = $this->createForm(LoginType::class, $user);

        // Handle the form submission
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // You can handle the login logic here
            // Typically, you will authenticate the user using Symfony's Security component

            // Example:
            $user = $this->getUser();

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('login/admin.html.twig', [
            'controller_name' => 'LoginController',
            'title' => $title,
            'form' => $form->createView(),
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    // #[Route('/album/login', name: 'app_login')]
    // public function jsp(AuthenticationUtils $authenticationUtils, Request $request, UserPasswordHasherInterface $passwordEncoder): Response
    // {
    //     // Get the login error if there is one
    //     $error = $authenticationUtils->getLastAuthenticationError();

    //     // Last username entered by the user
    //     $lastUsername = $authenticationUtils->getLastUsername();

    //     $user = new User();
    //     $form = $this->createForm(LoginType::class, $user);

    //     // Handle the form submission
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         // You can handle the login logic here
    //         // Typically, you will authenticate the user using Symfony's Security component

    //         // Example:
    //         $user = $this->getUser();
    //         return $this->redirectToRoute('app_admin');
    //     }

    //     return $this->render('login/admin.html.twig', [
    //         'controller_name' => 'LoginController',
    //         'form' => $form->createView(),
    //         'last_username' => $lastUsername,
    //         'error' => $error,
    //     ]);
    // }

    #[Route('/logout', name: 'app_logout')]
    public function logout(SecurityBundle $security)
    {
        // logout the user in on the current firewall
        $security->logout();

        // you can also disable the csrf logout
        $security->logout(false);

        return $this->redirectToRoute('app_home');
    }
}
