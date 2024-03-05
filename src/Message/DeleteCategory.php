<?php

namespace App\Message;

use App\Entity\Category;

class DeleteCategory
{
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Get the value of category.
     */
    public function getCategory(): Category
    {
        return $this->category;
    }
}
