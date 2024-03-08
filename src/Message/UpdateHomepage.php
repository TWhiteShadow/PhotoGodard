<?php

namespace App\Message;

use App\Entity\Homepage;

class UpdateHomepage
{
    private $homepage;
    private $defaultHomepage;
    private $imageFiles;

    public function __construct(Homepage $homepage, Homepage $defaultHomepage, ?array $imageFiles = null)
    {
        $this->homepage = $homepage;
        $this->defaultHomepage = $defaultHomepage;
        $this->imageFiles = $imageFiles;
    }

    /**
     * Get the value of imageFiles.
     */
    public function getImageFiles(): ?array
    {
        return $this->imageFiles;
    }

    /**
     * Get the value of homepage.
     */
    public function getHomepage(): Homepage
    {
        return $this->homepage;
    }

    /**
     * Get the value of defaultHomepage.
     */
    public function getDefaultHomepage(): Homepage
    {
        return $this->defaultHomepage;
    }
}
