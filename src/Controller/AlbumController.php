<?php

namespace App\Controller;

use App\Entity\Album;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AlbumController extends AbstractController
{
    #[Route('/album/{id}', name: 'app_album_show')]
    public function show(Album $album): Response
    {
        $photos = $album->getPhotos();
        return $this->render('album/show.html.twig', [
            'controller_name' => 'AlbumController',
            'album' => $album,
            'photos' => $photos,
        ]);
    }
}
