<?php

namespace App\MessageHandler;

use App\Entity\Category;
use App\Entity\Photo;
use App\Message\UpdateCategory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class UpdateCategoryHandler
{
    private $entityManager;
    private $uploadedFiles;
    private $category;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(UpdateCategory $command): void
    {
        $this->category = $command->getCategory();
        $this->uploadedFiles = $command->getUploadedFiles();
        $this->entityManager->persist($this->category);
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
                $photo = new Photo($imageFile);

                // Ajouter la photo à l'category
                $this->category->addPhoto($photo);
                $this->entityManager->persist($photo);
            }
        }
    }
}
