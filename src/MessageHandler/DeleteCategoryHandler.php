<?php

namespace App\MessageHandler;

use App\Message\DeleteCategory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class DeleteCategoryHandler
{
    private $entityManager;
    private $parameterBag;
    private $filesystem;
    private $category;

    public function __construct(EntityManagerInterface $entityManager, ParameterBagInterface $parameterBag, Filesystem $filesystem)
    {
        $this->entityManager = $entityManager;
        $this->parameterBag = $parameterBag;
        $this->filesystem = $filesystem;
    }

    public function __invoke(DeleteCategory $command): void
    {
        $this->category = $command->getCategory();
        if (count($this->category->getPhotos()) > 0) {
            if (null !== $this->category->getFavoritePhoto()) {
                $this->category->setFavoritePhoto(null);
            }
            $this->filesystem->remove($this->parameterBag->get('kernel.project_dir').'/public/photos/public/'.strtoupper($this->category->getUniqId()));
        }
        $this->category->setFavoritePhoto(null);
        $this->entityManager->remove($this->category);
        $this->entityManager->flush();
    }
}
