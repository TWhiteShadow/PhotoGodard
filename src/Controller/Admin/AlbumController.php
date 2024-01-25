<?php

namespace App\Controller\Admin;

use App\Entity\Album;
use App\Entity\Photo;
use App\Form\AlbumType;
use App\Repository\AlbumRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
            foreach($uploadedFiles as $uploadedFile){

                $imageFileArray = $uploadedFile->getImageFileArray();
                foreach ($imageFileArray as $imageFile) {
                    $photo = new Photo();
    
                    $file = $imageFile; // Notez l'indice [0] pour obtenir le premier fichier
                    $photo->setImageFile($file);
                    $photo->setCreatedAt(new \DateTimeImmutable);
                    $photo->setUpdatedAt(new \DateTimeImmutable);
    
                    // Ajouter la photo à l'album
                    $album->addPhoto($photo);
                    $entityManager->persist($photo);
                }
            }

            
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_album_index', [], Response::HTTP_SEE_OTHER);
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

            $entityManager->flush();

            return $this->redirectToRoute('app_admin_album_index', [], Response::HTTP_SEE_OTHER);
        }
        $photos = $album->getPhotos();
        return $this->render('admin/album/edit.html.twig', [
            'album' => $album,
            'photos' => $photos,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_album_delete', methods: ['POST'])]
    public function delete(Request $request, Album $album, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$album->getId(), $request->request->get('_token'))) {

            $photos = $album->getPhotos();
            foreach ($photos as $photo) {
                if ($photo) {
                    if (!$photo->getCategory()) {
                        $entityManager->remove($photo);
                    } else {
                        $photo->setAlbum(null);
                    }
                }
            }
            $entityManager->remove($album);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_album_index', [], Response::HTTP_SEE_OTHER);
    }
}
