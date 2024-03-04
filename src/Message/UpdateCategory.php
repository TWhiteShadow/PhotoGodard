<?php 

namespace App\Message;

use App\Entity\Category;

class UpdateCategory {
    private $category;
    private $uploadedFiles;
    
    public function __construct(Category $category, array $uploadedFiles) {
        $this->category = $category;
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
     * Get the value of category
     */ 
    public function getCategory(): Category
    {
        return $this->category;
    }
}