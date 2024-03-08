<?php

namespace App\Message;

use App\Entity\Album;

class DeleteAlbum
{
    private $album;

    public function __construct(Album $album)
    {
        $this->album = $album;
    }

    /**
     * Get the value of album.
     */
    public function getAlbum(): Album
    {
        return $this->album;
    }
}
