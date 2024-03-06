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
        $limit = 9;
        $photos = $photoRepository->findBy(
            ['category' => $category],
            ['id' => 'ASC'],
            $limit,
        );
        if (empty($photos)) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('category/show.html.twig', [
            'controller_name' => 'CategoryController',
            'category' => $category,
            'photos' => $photos,
            'limit' => $limit,
        ]);
    }

    #[Route('/category/{id}/pagination/{offset}', name: 'app_category_show_pagination')]
    public function pagination(Category $category, PhotoRepository $photoRepository, int $offset): Response
    {
        $limit = 9;
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
        $href = `{{ asset('photos/public/' ~ category.getUniqId()|upper ~ '/' ~ photo.getFilename()) | imagine_filter('my_watermark_filter')}}`;
        $src = `{{ asset('photos/public/' ~ category.getUniqId()|upper ~ '/' ~ photo.getFilename()) | imagine_filter('thumbnail_web_path')}}`;

        return $this->render('_pagination_show_photo.html.twig', [
            'href' => $href,
            'src' => $src,
            'controller_name' => 'CategoryController',
            'entityName' => $category->getName(),
            'entity' => $category,
            'photos' => $photos,
            'isCateg' => true,
        ]);
    }
}
