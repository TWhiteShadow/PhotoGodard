<?php

namespace App\MessageHandler;

use App\Entity\Album;
use App\Entity\Photo;
use App\Message\DeleteMultiplePhotos;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class DeleteMultiplePhotosHandler
{
    private $entityManager;
    private $parameterBag;
    private $filesystem;
    private $photosIds;

    public function __construct(EntityManagerInterface $entityManager, ParameterBagInterface $parameterBag)
    {
        $this->entityManager = $entityManager;
        $this->parameterBag = $parameterBag;
    }

    public function __invoke(DeleteMultiplePhotos $command): void
    {
        $this->photosIds = $command->getPhotosIds();
        $this->delete();
        // Enregistrez toutes les modifications dans la base de données
        $this->entityManager->flush();
    }

    public function delete()
    {
        // Supprimez les photos correspondantes
        foreach ($this->photosIds as $photoId) {
            $photo = $this->entityManager->getRepository(Photo::class)->find($photoId);
            if ($photo) {
                // Si la photo est associée à un album
                if ($album = $photo->getAlbum()) {
                    // Supprimer la référence à la photo dans l'album
                    if ($album->getFavoritePhoto() === $photo) {
                        $album->setFavoritePhoto(null);
                    }
                    // Supprimer la référence à la photo dans l'album
                    $album->removePhoto($photo);
                    // Enregistrez les modifications dans l'entité de l'album
                    $this->entityManager->persist($album);
                    try {
                        unlink($this->parameterBag->get('kernel.project_dir').'/storage/images/private/'.strtoupper($album->getUniqId()).'/'.$photo->getFilename());
                    } catch (\Exception $e) {
                        continue;
                    }
                }

                // Si la photo est associée à une catégorie
                if ($category = $photo->getCategory()) {
                    // Supprimer la référence à la photo dans la catégorie
                    if ($category->getFavoritePhoto() === $photo) {
                        $category->setFavoritePhoto(null);
                    }
                    // Supprimer la référence à la photo dans la catégorie
                    $category->removePhoto($photo);
                    // Enregistrez les modifications dans l'entité de la catégorie
                    $this->entityManager->persist($category);
                    try {
                        unlink($this->parameterBag->get('kernel.project_dir').'/public/photos/public/'.strtoupper($category->getUniqId()).'/'.$photo->getFilename());
                    } catch (\Exception $e) {
                        continue;
                    }
                }

                // Supprimer la photo
                $this->entityManager->remove($photo);
            }
        }
    }
}
