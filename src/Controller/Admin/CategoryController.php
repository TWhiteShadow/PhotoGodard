<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Photo;
use App\Form\CategoryType;
use App\Message\CreateCategory;
use App\Message\DeleteCategory;
use App\Message\UpdateCategory;
use App\Message\UpdateFavoritePhotoCategory;
use App\Repository\CategoryRepository;
use App\Repository\PhotoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/category')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'app_admin_category_index', methods: ['GET'])]
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('admin/category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MessageBusInterface $bus): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFiles = $form->get('newPhotos')->getData(); // get the first element
            $bus->dispatch(new CreateCategory($category, $uploadedFiles));

            return $this->redirectToRoute('app_admin_category_show', ['id' => $category->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/category/new.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_category_show', methods: ['GET'])]
    public function show(Category $category, PhotoRepository $photoRepository): Response
    {
        $limit = $this->getParameter('default_limit');
        $photos = $photoRepository->findBy(
            ['category' => $category],
            ['id' => 'ASC'],
            $limit,
        );

        return $this->render('admin/category/show.html.twig', [
            'category' => $category,
            'photos' => $photos,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Category $category, PhotoRepository $photoRepository, MessageBusInterface $bus): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFiles = $form->get('newPhotos')->getData(); // get the first element
            $bus->dispatch(new UpdateCategory($category, $uploadedFiles));

            return $this->redirectToRoute('app_admin_category_show', ['id' => $category->getId()], Response::HTTP_SEE_OTHER);
        }

        $limit = $this->getParameter('default_limit');
        $photos = $photoRepository->findBy(
            ['category' => $category],
            ['id' => 'ASC'],
            $limit,
        );

        return $this->render('admin/category/edit.html.twig', [
            'category' => $category,
            'form' => $form,
            'photos' => $photos,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_category_delete', methods: ['POST'])]
    public function delete(Request $request, Category $category, MessageBusInterface $bus): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $bus->dispatch(new DeleteCategory($category));
        }

        return $this->redirectToRoute('app_admin_category_index');
    }

    #[Route('/{id}/update/favorite', name: 'app_admin_category_update_favorite', methods: ['POST'])]
    public function update_favorite_photo(Request $request, Category $category, MessageBusInterface $bus)
    {
        $photoId = $request->request->get('photoId');
        if (empty($photoId)) {
            $photoId = null;
        }
        $updateResult = $bus->dispatch(new UpdateFavoritePhotoCategory($category, $photoId));
        if ($updateResult) {
            // Retourner une réponse avec l'identifiant de la photo
            return new Response($photoId, Response::HTTP_OK);
        }

        return new Response('La photo spécifiée n\'appartient pas à cette catégorie', Response::HTTP_BAD_REQUEST);
    }
}
