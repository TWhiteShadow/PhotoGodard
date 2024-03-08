<?php

namespace App\Controller;

use App\Entity\Album;
use App\Entity\Photo;
use Cocur\Slugify\Slugify;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class FileController extends AbstractController
{
    #[Route('/file/{photo}', 'app_file')]
    public function getFile(Photo $photo, Session $session): Response
    {
        $favoritePhoto = false;
        if (empty($photo)) {
            throw $this->createNotFoundException('No photo found');
        }

        if (null === $photo->getAlbum()) {
            throw $this->createNotFoundException('The photo is not linked to an album');
        }
        if (!empty($photo->getAlbum()->getFavoritePhoto()) && $photo->getAlbum()->getFavoritePhoto()->getId() === $photo->getId()) {
            $favoritePhoto = true;
        }

        if (false === $favoritePhoto) {
            if (empty($this->getUser()) && empty($session->get('ROLE_ALBUM_ACCESS'))) {
                throw new AccessDeniedHttpException('Accès refusé. Vous devez être connecté pour accéder à cette ressource.');
            }
            if (empty($this->getUser()) && (!empty($session->get('ROLE_ALBUM_ACCESS')) && $session->get('ROLE_ALBUM_ACCESS') !== $photo->getAlbum()->getUniqId().'-ACCESS')) {
                throw new AccessDeniedHttpException('Accès refusé. Vous devez être connecté pour accéder à cette ressource.');
            }
            if (!empty($this->getUser()) && !in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
                throw new AccessDeniedHttpException('Accès refusé. Vous devez être connecté pour accéder à cette ressource.');
            }
        }

        // Obtenez le chemin absolu vers le répertoire des images privées
        $privateImagesDir = $this->getParameter('kernel.project_dir').'/storage/images/private';
        $album = strtoupper($photo->getAlbum()->getUniqId());

        // Concaténez le chemin du fichier spécifique que vous souhaitez charger
        $filePath = $privateImagesDir.'/'.$album.'/'.$photo->getFilename();

        // Créez une instance de Symfony\Component\HttpFoundation\File\File
        $file = file_get_contents($filePath);
        $file = new Response($file, 200);

        // Vous pouvez maintenant utiliser $file comme réponse pour envoyer le fichier
        return $file;
    }

}
