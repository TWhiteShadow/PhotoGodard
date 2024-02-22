<?php

namespace App\Controller;

use App\Entity\Album;
use App\Form\AlbumLoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AlbumController extends AbstractController
{
    #[Route('/album/{id}', name: 'app_album_show')]
    public function show(Album $album, AuthenticationUtils $authenticationUtils, Request $request, UserPasswordHasherInterface $passwordEncoder): Response
    {
        $session = $request->getSession();
        if ((!empty($session->get('ROLE_ALBUM_ACCESS')) && $session->get('ROLE_ALBUM_ACCESS') == $album->getUniqId().'-ACCESS') || !empty($this->getUser()) && in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            $photos = $album->getPhotos();
            if(count($photos) == 0) {
                return $this->redirectToRoute('app_home');
            }

            // $session->remove('ROLE_ALBUM_ACCESS');
            return $this->render('album/show.html.twig', [
                'controller_name' => 'AlbumController',
                'album' => $album,
                'photos' => $photos,
                'session' => $session,
                'title' => $album->getName(),
            ]);
        }
        // Get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        $albumLoginForm = $this->createForm(AlbumLoginType::class);

        // Handle the form submission
        $albumLoginForm->handleRequest($request);

        if ($albumLoginForm->isSubmitted() && $albumLoginForm->isValid()) {
            $data = $albumLoginForm->getData();
            $identifiant = $data['identifiant'];
            $password = $data['password'];

            if ($identifiant == $album->getId() && trim($password) == $album->getPassword()) {
                // Album login success
                // You can handle the login logic here
                // For example, you can redirect to a different page
                // return $this->redirectToRoute('app_album_dashboard');
                $session->set('ROLE_ALBUM_ACCESS', $album->getUniqId().'-ACCESS');

                $photos = $album->getPhotos();

                return $this->render('album/show.html.twig', [
                    'controller_name' => 'AlbumController',
                    'album' => $album,
                    'photos' => $photos,
                    'session' => $session,
                    'title' => $album->getName(),
                ]);
            }
        }

        // return $this->render('album/show.html.twig', [
        //     'controller_name' => 'AlbumController',
        //     'album' => $album,
        //     'albumLoginForm' => $albumLoginForm->createView(),
        //     'error' => $error,
        // ]);

        $favoritePhoto = $album->getFavoritePhoto();

        return $this->render('login/album.html.twig', [
            'form' => $albumLoginForm->createView(),
            'error' => $error,
            'favoritePhoto' => $favoritePhoto,
            'title' => $album->getName(),
        ]);
    }
}
