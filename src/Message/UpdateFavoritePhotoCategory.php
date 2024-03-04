<?php 
namespace App\Message;

use App\Entity\Category;

class UpdateFavoritePhotoCategory{
    private $category;
    private $photoId;
    
    public function __construct(Category $category, int $photoId) {
        $this->category = $category;
        $this->photoId = $photoId;
    }

    /**
     * Get the value of category
     */ 
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * Get the value of photoId
     */ 
    public function getPhotoId(): int
    {
        return $this->photoId;
    }
}