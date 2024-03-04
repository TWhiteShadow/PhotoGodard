<?php

namespace App\Controller;

use App\Repository\AlbumRepository;
use App\Repository\CategoryRepository;
use App\Repository\FooterLinksRepository;
use App\Repository\HomepageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CategoryRepository $categoryRepository, FooterLinksRepository $footerLinksRepository , AlbumRepository $albumRepository, HomepageRepository $homepageRepository): Response
    {
        $categories = $categoryRepository->findAll();
        $albums = $albumRepository->findBy([], ['id' => 'DESC']);
        $homepage = $homepageRepository->findAll()[0];
        $footer_links = $footerLinksRepository->findBy(['visible'=> 1]);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'categories' => $categories,
            'albums' => $albums,
            'homepage' => $homepage,
            'footer_links' => $footer_links,
        ]);
    }

    #[Route('/findAlbumByName', name: 'findAlbumByName')]
    public function findAlbumByName(AlbumRepository $albumRepository, Request $request, Environment $twig): Response
    {
        $value = $request->query->get('value');
        $albums = $albumRepository->findByName($value);

        if (empty($albums)) {
            return new Response('Error : No Albums found', Response::HTTP_NOT_FOUND);
        }
        // Render the Twig template with albums data
        $html = $twig->render('home/findAlbumByName.html.twig', [
            'albums' => $albums,
        ]);

        // Return the rendered HTML as response
        return new Response($html);
    }
}
