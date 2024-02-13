<?php

namespace App\Controller;

use App\Repository\AlbumRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CategoryRepository $categoryRepository, AlbumRepository $albumRepository): Response
    {
        $categories = $categoryRepository->findAll();
        $albums = $albumRepository->findBy([], ["id" => 'DESC']);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'categories' => $categories,
            'albums' => $albums,
        ]);
    }

    #[Route('/jsp', name: 'jsp')]
    public function jsp(): Response
    {
        return $this->render('home/jsp.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
