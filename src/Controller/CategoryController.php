<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        $photos = [];
        foreach ($categories as $category) {
            $photosA = $category->getPhotos()->toArray();
            shuffle($photosA);
            $photos = array_merge($photos, $photosA);
        }
        shuffle($photos);

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
            'photos' => $photos,
        ]);
    }

    #[Route('/category/{id}', name: 'app_category_show')]
    public function show(Category $category): Response
    {
        $photos = $category->getPhotos();

        return $this->render('category/show.html.twig', [
            'controller_name' => 'CategoryController',
            'category' => $category,
            'photos' => $photos,
        ]);
    }
}
