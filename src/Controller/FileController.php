<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Repository\AlbumRepository;
use App\Repository\CategoryRepository;
use App\Repository\PhotoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

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

    #[Route('/{isAdmin}/{entityName}/{id}/pagination/{offset}', name: 'app_entity_show_pagination')]
    public function pagination2(int $isAdmin, string $entityName, CategoryRepository $categoryRepository, AlbumRepository $albumRepository, PhotoRepository $photoRepository, int $id, int $offset, Session $session): Response
    {
        $isCateg = false;
        $limit = $this->getParameter('default_limit');
        --$offset;
        if ($offset > 0) {
            $offset = $offset * $limit;
        }

        switch ($isAdmin) {
            case 0:
                switch ($entityName) {
                    case 'category':
                        $entity = $categoryRepository->findOneBy(['id' => $id]);
                        $photos = $photoRepository->findBy(
                            [$entityName => $id],
                            ['id' => 'ASC'],
                            $limit,
                            $offset,
                        );
                        $isCateg = true;
                        break;

                    case 'album':
                        $entity = $albumRepository->findOneBy(['id' => $id]);
                        if (empty($this->getUser()) && empty($session->get('ROLE_ALBUM_ACCESS'))) {
                            throw new AccessDeniedHttpException('Accès refusé. Vous devez être connecté pour accéder à cette ressource.');
                        }
                        if (empty($this->getUser()) && (!empty($session->get('ROLE_ALBUM_ACCESS')) && $session->get('ROLE_ALBUM_ACCESS') !== $entity->getUniqId().'-ACCESS')) {
                            throw new AccessDeniedHttpException('Accès refusé. Vous devez être connecté pour accéder à cette ressource.');
                        }
                        if (!empty($this->getUser()) && !in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
                            throw new AccessDeniedHttpException('Accès refusé. Vous devez être connecté pour accéder à cette ressource.');
                        }
                        $photos = $photoRepository->findBy(
                            [$entityName => $id],
                            ['id' => 'ASC'],
                            $limit,
                            $offset,
                        );

                        break;
                    default:
                        throw new NotFoundHttpException('Unable to find entity.');
                        // break;
                }
                break;
            case 1:
                if (empty($this->getUser())) {
                    throw new AccessDeniedHttpException('Accès refusé. Vous devez être connecté pour accéder à cette ressource.');
                }
                if (!empty($this->getUser()) && !in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
                    throw new AccessDeniedHttpException('Accès refusé. Vous devez être connecté pour accéder à cette ressource.');
                }
                switch ($entityName) {
                    case 'category':
                        $entity = $categoryRepository->findOneBy(['id' => $id]);
                        $photos = $photoRepository->findBy(
                            [$entityName => $id],
                            ['id' => 'ASC'],
                            $limit,
                            $offset,
                        );
                        $isCateg = true;
                        break;
                    case 'album':
                        $entity = $albumRepository->findOneBy(['id' => $id]);
                        $photos = $photoRepository->findBy(
                            [$entityName => $id],
                            ['id' => 'ASC'],
                            $limit,
                            $offset,
                        );
                        break;
                    default:
                        throw new NotFoundHttpException('Entity Not Found');
                }
                break;
            default:
                throw new NotFoundHttpException('Could not find isAdmin.');
        }

        if (empty($photos)) {
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        return $this->render('_pagination_show_photo.html.twig', [
            'entityName' => $entityName,
            'entity' => $entity,
            'photos' => $photos,
            'isCateg' => $isCateg,
            'isAdmin' => $isAdmin,
        ]);
    }
}
