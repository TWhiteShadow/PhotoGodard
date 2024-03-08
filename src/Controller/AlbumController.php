<?php

namespace App\Controller;

use App\Entity\Album;
use App\Form\AlbumLoginType;
use App\Repository\PhotoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AlbumController extends AbstractController
{
    #[Route('/album/{id}', name: 'app_album_show')]
    public function show(Album $album, AuthenticationUtils $authenticationUtils, Request $request, PhotoRepository $photoRepository): Response
    {
        $session = $request->getSession();
        if ((!empty($session->get('ROLE_ALBUM_ACCESS')) && $session->get('ROLE_ALBUM_ACCESS') == $album->getUniqId().'-ACCESS') || !empty($this->getUser()) && in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            $limit = $this->getParameter('default_limit');
            $photos = $photoRepository->findBy(
                ['album' => $album],
                ['id' => 'ASC'],
                $limit,
            );
            if (empty($photos)) {
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
                $session->set('ROLE_ALBUM_ACCESS', $album->getUniqId().'-ACCESS');

                $limit = $this->getParameter('default_limit');
                $photos = $photoRepository->findBy(
                    ['album' => $album],
                    ['id' => 'ASC'],
                    $limit,
                );
                if (empty($photos)) {
                    return $this->redirectToRoute('app_home');
                }

                return $this->render('album/show.html.twig', [
                    'album' => $album,
                    'photos' => $photos,
                    'session' => $session,
                    'title' => $album->getName(),
                ]);
            }
        }

        $favoritePhoto = $album->getFavoritePhoto();

        return $this->render('album/login.html.twig', [
            'form' => $albumLoginForm->createView(),
            'error' => $error,
            'favoritePhoto' => $favoritePhoto,
            'title' => $album->getName(),
        ]);
    }

    #[Route('/album/{id}/pagination/{offset}', name: 'app_album_show_pagination')]
    public function pagination(Album $album, PhotoRepository $photoRepository, int $offset): Response
    {
        $limit = $this->getParameter('default_limit');
        --$offset;
        if ($offset > 0) {
            $offset = $offset * $limit;
        }
        $photos = $photoRepository->findBy(
            ['album' => $album],
            ['id' => 'ASC'],
            $limit,
            $offset,
        );
        if (empty($photos)) {
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        return $this->render('_pagination_show_photo.html.twig', [
            'entityName' => $album->getName(),
            'entity' => $album,
            'photos' => $photos,
            'isCateg' => false,
        ]);
    }
}
