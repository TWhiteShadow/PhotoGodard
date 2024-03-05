<?php

namespace App\Message;

class DeleteMultiplePhotos
{
    private $photosIds;

    public function __construct(array $photosIds)
    {
        $this->photosIds = $photosIds;
    }

    /**
     * Get the value of photosIds.
     */
    public function getPhotosIds(): array
    {
        return $this->photosIds;
    }
}
