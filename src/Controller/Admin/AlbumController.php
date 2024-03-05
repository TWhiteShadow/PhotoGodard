<?php

namespace App\Controller\Admin;

use App\Entity\Album;
use App\Entity\Photo;
use App\Form\AlbumType;
use App\Message\CreateAlbum;
use App\Message\DeleteAlbum;
use App\Message\UpdateAlbum;
use App\Message\UpdateFavoritePhotoAlbum;
use App\Repository\AlbumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
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
    public function new(Request $request, MessageBusInterface $bus): Response
    {
        $album = new Album();
        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFiles = $form->get('newPhotos')->getData();
            $message = new CreateAlbum($album, $uploadedFiles);
            $bus->dispatch($message);

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
    public function edit(Request $request, Album $album, MessageBusInterface $bus): Response
    {
        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFiles = $form->get('newPhotos')->getData(); // get the first element
            $message = new UpdateAlbum($album, $uploadedFiles);
            $bus->dispatch($message);

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
    public function delete(Request $request, Album $album, MessageBusInterface $bus): Response
    {
        if ($this->isCsrfTokenValid('delete'.$album->getId(), $request->request->get('_token'))) {
            $bus->dispatch(new DeleteAlbum($album));
        }

        return $this->redirectToRoute('app_admin_album_index');
    }

    #[Route('/{id}/update/favorite', name: 'app_admin_album_update_favorite', methods: ['POST'])]
    public function update_favorite_photo(Request $request, Album $album, MessageBusInterface $bus)
    {
        $photoId = $request->request->get('photoId');
        $updateResult = $bus->dispatch(new UpdateFavoritePhotoAlbum($album, $photoId));
        if ($updateResult) {
            // Retourner une réponse avec l'identifiant de la photo
            return new Response($photoId, Response::HTTP_OK);
        }

        // Si la photo n'appartient pas à l'album, retourner une erreur
        return new Response('La photo spécifiée n\'appartient pas à cet album', Response::HTTP_BAD_REQUEST);
    }
}
