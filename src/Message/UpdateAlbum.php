<?php 

namespace App\Message;

use App\Entity\Album;

class UpdateAlbum {
    private $album;
    private $uploadedFiles;
    
    public function __construct(Album $album, array $uploadedFiles) {
        $this->album = $album;
        $this->uploadedFiles = $uploadedFiles;
    }
    /**
     * Get the value of uploadedFiles
     */ 
    public function getUploadedFiles(): array
    {
        return $this->uploadedFiles;
    }


    /**
     * Get the value of album
     */ 
    public function getAlbum(): Album
    {
        return $this->album;
    }
}