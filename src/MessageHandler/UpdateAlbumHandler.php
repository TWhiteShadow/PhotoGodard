<?php

namespace App\MessageHandler;

use App\Entity\Album;
use App\Entity\Photo;
use App\Message\UpdateAlbum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class UpdateAlbumHandler
{
    private $entityManager;
    private $uploadedFiles;
    private $album;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(UpdateAlbum $command): void
    {
        $this->album = $command->getAlbum();
        $this->uploadedFiles = $command->getUploadedFiles();
        $this->entityManager->persist($this->album);
        $this->handleUploadedPhoto();

        $this->entityManager->flush();
    }

    private function handleUploadedPhoto(): void
    {
        foreach ($this->uploadedFiles as $uploadedFile) {
            if (empty($uploadedFile)) {
                continue;
            }

            $imageFileArray = $uploadedFile->getImageFileArray();
            foreach ($imageFileArray as $imageFile) {
                $file = $imageFile;
                $photo = new Photo($file);

                // Ajouter la photo à l'album
                $this->album->addPhoto($photo);
                $this->entityManager->persist($photo);
            }
        }
    }
}
