<?php
namespace App\MessageHandler;

use App\Entity\Album;
use App\Entity\Photo;
use App\Message\CreateEntity;
use App\Message\DeleteAlbum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class DeleteAlbumHandler {
    private $entityManager;
    private $parameterBag;
    private $filesystem;
    private $album;
    public function __construct(EntityManagerInterface $entityManager, ParameterBagInterface $parameterBag, Filesystem $filesystem) {
        $this->entityManager = $entityManager;
        $this->parameterBag = $parameterBag;
        $this->filesystem = $filesystem;
    }
    public function __invoke(DeleteAlbum $command): void
    {
        $this->album = $command->getAlbum();
        if (count($this->album->getPhotos()) > 0) {
            if (null !== $this->album->getFavoritePhoto()) {
                $this->album->setFavoritePhoto(null);
            }
            $this->filesystem->remove($this->parameterBag->get('kernel.project_dir').'/storage/images/private/'.strtoupper($this->album->getUniqId()));
        }
        $this->album->setFavoritePhoto(null);
        $this->entityManager->remove($this->album);
        $this->entityManager->flush();

    }

}