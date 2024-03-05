<?php

namespace App\Controller;

use App\Repository\PhotoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;

class CategoryController extends AbstractController
{
    #[Route('/category/{id}', name: 'app_category_show')]
    public function show(Category $category, PhotoRepository $photoRepository): Response
    {
        $photos = $category->getPhotos();
        $photos = $photoRepository->findBy(
            ['category' => $category],
            ['id' => 'ASC'],
            15,
        );
        if (empty($photos)) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('category/show.html.twig', [
            'controller_name' => 'CategoryController',
            'category' => $category,
            'photos' => $photos,
        ]);
    }

    #[Route('/category/{id}/pagination/{offset}', name: 'app_category_show_pagination')]
    public function pagination(Category $category, PhotoRepository $photoRepository, int $offset): Response
    {
        $limit = 15;
        $offset -= 1;
        if($offset > 0) {
            $offset = $offset * $limit;
        }
        $photos = $photoRepository->findBy(
            ['category' => $category],
            ['id' => 'ASC'],
            $limit,
            $offset,
        );
        if (empty($photos)) {
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        return $this->render('_pagination_show_photo.html.twig', [
            'href' => `{{ asset('photos/public/' ~ category.getUniqId()|upper ~ '/' ~ photo.getFilename()) | imagine_filter('my_watermark_filter')}}`,
            'src' => `{{ asset('photos/public/' ~ category.getUniqId()|upper ~ '/' ~ photo.getFilename()) | imagine_filter('thumbnail_web_path')}}`,
            'controller_name' => 'CategoryController',
            'entityName' => $category->getName(),
            'category' => $category,
            'photos' => $photos,
        ]);
    }
}
