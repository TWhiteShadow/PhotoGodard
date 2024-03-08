<?php

namespace App\MessageHandler;

use App\Entity\Category;
use App\Entity\Photo;
use App\Message\UpdateFavoritePhotoCategory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class UpdateFavoritePhotoCategoryHandler
{
    private $entityManager;
    private $photoId;
    private $category;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(UpdateFavoritePhotoCategory $command): bool
    {
        $this->category = $command->getCategory();
        $this->photoId = $command->getPhotoId();
        $updateResult = $this->updateFavoritePhoto();

        return $updateResult;
    }

    private function updateFavoritePhoto(): bool
    {
        $photo = null;

        // Si l'identifiant de la photo n'est pas nul, cherchez la photo correspondante
        if (null === $this->photoId) {
            $this->category->setFavoritePhoto(null);
            $this->entityManager->flush();

            return true;
        }

        $photo = $this->entityManager->getRepository(Photo::class)->find($this->photoId);
        if (null === $photo) {
            return false;
        }
        if ((null === $photo->getCategory()) || ($photo->getCategory()->getId() !== $this->category->getId())) {
            // Si la photo n'appartient pas à l'category
            return false;
        }

        // Définir la photo favorite de l'category
        $this->category->setFavoritePhoto($photo);
        $this->entityManager->flush();

        return true;
    }
}
