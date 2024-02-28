<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;

class CategoryController extends AbstractController
{
    #[Route('/category/{id}', name: 'app_category_show')]
    public function show(Category $category): Response
    {
        $photos = $category->getPhotos();
        if (empty($photos)) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('category/show.html.twig', [
            'controller_name' => 'CategoryController',
            'category' => $category,
            'photos' => $photos,
        ]);
    }
}
