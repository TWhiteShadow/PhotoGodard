<?php
namespace App\MessageHandler;

use App\Entity\Album;
use App\Entity\Photo;
use App\Message\UpdateAlbum;
use App\Message\UpdateFavoritePhotoAlbum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class UpdateFavoritePhotoAlbumHandler {
    private $entityManager;
    private $photoId;
    private $album;
    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }
    public function __invoke(UpdateFavoritePhotoAlbum $command): bool
    {
        $this->album = $command->getAlbum();
        $this->photoId = $command->getPhotoId();

        $updateResult = $this->updateFavoritePhoto();

        return $updateResult;       

    }

    private function updateFavoritePhoto() : bool
    {
        $photo = null;

        // Si l'identifiant de la photo n'est pas nul, cherchez la photo correspondante
        if (null === $this->photoId) {
            return false;
        }

        $photo = $this->entityManager->getRepository(Photo::class)->find($this->photoId);
        if (null === $photo) {
            return false;
        }
        if ((null === $photo->getAlbum()) || ($photo->getAlbum()->getId() !== $this->album->getId())) {
            // Si la photo n'appartient pas à l'album
            return false;
        }
    

        // Définir la photo favorite de l'album
        $this->album->setFavoritePhoto($photo);
        $this->entityManager->flush();
        return true;

    }
}