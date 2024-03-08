<?php

namespace App\Controller;

use App\Entity\Album;
use App\Form\AlbumLoginType;
use Cocur\Slugify\Slugify;
use App\Repository\PhotoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
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

    #[Route('/album/{album}/createzip', name: 'app_folder_zip')]
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
