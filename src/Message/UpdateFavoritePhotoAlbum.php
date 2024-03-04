<?php 
namespace App\Message;

use App\Entity\Album;

class UpdateFavoritePhotoAlbum{
    private $album;
    private $photoId;
    
    public function __construct(Album $album, int $photoId) {
        $this->album = $album;
        $this->photoId = $photoId;
    }

    /**
     * Get the value of album
     */ 
    public function getAlbum(): Album
    {
        return $this->album;
    }

    /**
     * Get the value of photoId
     */ 
    public function getPhotoId(): int
    {
        return $this->photoId;
    }
}