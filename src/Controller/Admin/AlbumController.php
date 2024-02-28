<?php

namespace App\Controller\Admin;

use App\Entity\Album;
use App\Entity\Photo;
use App\Form\AlbumType;
use App\Repository\AlbumRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/album')]
class AlbumController extends AbstractController
{
    #[Route('/', name: 'app_admin_album_index', methods: ['GET'])]
    public function index(AlbumRepository $albumRepository): Response
    {
        return $this->render('admin/album/index.html.twig', [
            'albums' => $albumRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_album_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $album = new Album();
        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFiles = $form->get('newPhotos')->getData(); // get the first element
            // dd($uploadedFiles);
            $album->setUniqId();
            $entityManager->persist($album);
            foreach ($uploadedFiles as $uploadedFile) {
                if (!empty($uploadedFile)) {
                    $imageFileArray = $uploadedFile->getImageFileArray();
                    foreach ($imageFileArray as $imageFile) {
                        $photo = new Photo();

                        $file = $imageFile; // Notez l'indice [0] pour obtenir le premier fichier
                        $photo->setImageFile($file);
                        $photo->setCreatedAt(new \DateTimeImmutable());
                        $photo->setUpdatedAt(new \DateTimeImmutable());

                        // Ajouter la photo à l'album
                        $album->addPhoto($photo);
                        $entityManager->persist($photo);
                    }
                }
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_admin_album_show', ['id' => $album->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/album/new.html.twig', [
            'album' => $album,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_album_show', methods: ['GET'])]
    public function show(Album $album): Response
    {
        $photos = $album->getPhotos();

        return $this->render('admin/album/show.html.twig', [
            'album' => $album,
            'photos' => $photos,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_album_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Album $album, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFiles = $form->get('newPhotos')->getData(); // get the first element
            foreach ($uploadedFiles as $uploadedFile) {
                if (!empty($uploadedFile)) {
                    $imageFileArray = $uploadedFile->getImageFileArray();
                    foreach ($imageFileArray as $imageFile) {
                        $photo = new Photo();

                        $file = $imageFile; // Notez l'indice [0] pour obtenir le premier fichier
                        $photo->setImageFile($file);
                        $photo->setCreatedAt(new \DateTimeImmutable());
                        $photo->setUpdatedAt(new \DateTimeImmutable());

                        // Ajouter la photo à l'album
                        $album->addPhoto($photo);
                        $entityManager->persist($photo);
                    }
                }
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_album_show', ['id' => $album->getId()], Response::HTTP_SEE_OTHER);
        }
        $photos = $album->getPhotos();

        return $this->render('admin/album/edit.html.twig', [
            'album' => $album,
            'photos' => $photos,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_album_delete', methods: ['POST'])]
    public function delete(Request $request, Album $album, EntityManagerInterface $entityManager, ParameterBagInterface $parameterBag, Filesystem $filesystem): Response
    {
        if ($this->isCsrfTokenValid('delete'.$album->getId(), $request->request->get('_token'))) {
            if (count($album->getPhotos()) > 0) {
                if (null !== $album->getFavoritePhoto()) {
                    $album->setFavoritePhoto(null);
                }
                $filesystem->remove($parameterBag->get('kernel.project_dir').'/storage/images/private/'.strtoupper($album->getUniqId()));
            }
            $album->setFavoritePhoto(null);
            $entityManager->remove($album);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_album_index');
    }

    #[Route('/{id}/update/favorite', name: 'app_admin_album_update_favorite', methods: ['POST'])]
    public function update_favorite_photo(Request $request, Album $album, EntityManagerInterface $entityManager)
    {
        $photoId = $request->request->get('photoId');
        $photo = null;

        // Si l'identifiant de la photo n'est pas nul, cherchez la photo correspondante
        if (null !== $photoId) {
            $photo = $entityManager->getRepository(Photo::class)->find($photoId);
            if (null !== $photo) {
                if ((null === $photo->getAlbum()) || ($photo->getAlbum()->getId() !== $album->getId())) {
                    // Si la photo n'appartient pas à l'album, retourner une erreur
                    return new Response('La photo spécifiée n\'appartient pas à cet album', Response::HTTP_BAD_REQUEST);
                }
            }
        }

        // Définir la photo favorite de l'album
        $album->setFavoritePhoto($photo);
        $entityManager->flush();

        // Retourner une réponse avec l'identifiant de la photo
        return new Response($photoId);
    }
}
