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

    #[Route('/createzip/{album}', name: 'app_folder_zip')]
    public function createZip(Album $album, Session $session, ParameterBagInterface $parameterBag, Filesystem $filesystem): JsonResponse
    {
        if (empty($album)) {
            return new Response('Album not found', Response::HTTP_NOT_FOUND);
        }
        if (empty($this->getUser()) && empty($session->get('ROLE_ALBUM_ACCESS'))) {
            throw new AccessDeniedHttpException('Accès refusé. Vous devez être connecté pour accéder à cette ressource.');
        }
        if (empty($this->getUser()) && (!empty($session->get('ROLE_ALBUM_ACCESS')) && $session->get('ROLE_ALBUM_ACCESS') !== $album->getUniqId().'-ACCESS')) {
            throw new AccessDeniedHttpException('Accès refusé. Vous devez être connecté pour accéder à cette ressource.');
        }
        if (!empty($this->getUser()) && !in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            throw new AccessDeniedHttpException('Accès refusé. Vous devez être connecté pour accéder à cette ressource.');
        }

        $slugify = new Slugify();
        $finder = new Finder();

        // Enter the name to creating zipped directory
        $zipFileName = strtoupper($slugify->slugify($album->getUniqId(), '_')).'.zip';
        $tempDir = $parameterBag->get('kernel.project_dir').'/public/temp_zip/'; // Assurez-vous que ce dossier existe et est accessible
        $zipFilePath = $tempDir.$zipFileName;

        if (file_exists($zipFilePath)) {
            $filesystem->remove($zipFilePath);
        }

        // Create new zip class
        $zip = new \ZipArchive();

        if (true === $zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE)) {
            // Store the path into the variable
            $dir = $parameterBag->get('kernel.project_dir').'/storage/images/private/'.strtoupper($album->getUniqId());
            $finder->files()->in($dir);

            if ($finder->hasResults()) {
                foreach ($finder as $file) {
                    $absoluteFilePath = $file->getRealPath();
                    $fileNameWithExtension = $file->getRelativePathname();
                    if (is_file($absoluteFilePath)) {
                        $zip->addFile($absoluteFilePath, $fileNameWithExtension);
                    }
                }
            }

            $zip->close();

            // Retourner une URL vers le fichier ZIP
            $zipUrl = $this->generateUrl('temporary_file', ['album' => $album->getId(), 'filename' => $zipFileName], UrlGeneratorInterface::ABSOLUTE_URL);
            // Assurez-vous de nettoyer les fichiers ZIP anciens ou temporaires régulièrement dans le dossier temp

            return new JsonResponse(['url' => $zipUrl]);
        }

        // Gérer l'échec de création du ZIP
        return new JsonResponse(['error' => 'Failed to create zip file.'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    #[Route('/temp/{album}/{filename}', name: 'temporary_file')]
    public function downloadTemporaryFile(Album $album, string $filename, Session $session, ParameterBagInterface $parameterBag): BinaryFileResponse
    {
        if (empty($album)) {
            throw new NotFoundHttpException('No album found');
        }
        if (empty($this->getUser()) && empty($session->get('ROLE_ALBUM_ACCESS'))) {
            throw new AccessDeniedHttpException('Accès refusé. Vous devez être connecté pour accéder à cette ressource.');
        }
        if (empty($this->getUser()) && (!empty($session->get('ROLE_ALBUM_ACCESS')) && $session->get('ROLE_ALBUM_ACCESS') !== $album->getUniqId().'-ACCESS')) {
            throw new AccessDeniedHttpException('Accès refusé. Vous devez être connecté pour accéder à cette ressource.');
        }
        if (!empty($this->getUser()) && !in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            throw new AccessDeniedHttpException('Accès refusé. Vous devez être connecté pour accéder à cette ressource.');
        }

        $tempDir = $parameterBag->get('kernel.project_dir').'/public/temp_zip/';
        $filePath = $tempDir.$filename;

        // Sécurité : eviter traversée de répertoire
        if (false !== strpos($filename, '..')) {
            throw $this->createNotFoundException('File not found.');
        }

        if (!file_exists($filePath)) {
            throw $this->createNotFoundException('File not found.');
        }

        // Reponse pour le téléchargement du fichier
        $response = new BinaryFileResponse($filePath);
        $slugify = new Slugify();   // Rename zip file name (uniqId) to album name for the clients
        $newFileName = $slugify->slugify(strtoupper($album->getName()), '_').'.zip';
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $newFileName
        );

        return $response;
    }
}
