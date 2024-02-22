<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Photo;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFiles = $form->get('newPhotos')->getData(); // get the first element
            $category->setUniqId();
            $entityManager->persist($category);
            foreach ($uploadedFiles as $uploadedFile) {
                if (!empty($uploadedFile)) {
                    $imageFileArray = $uploadedFile->getImageFileArray();
                    foreach ($imageFileArray as $imageFile) {
                        $photo = new Photo();

                        $photo->setImageFile($imageFile);
                        $photo->setCreatedAt(new \DateTimeImmutable());
                        $photo->setUpdatedAt(new \DateTimeImmutable());

                        // Ajouter la photo à l'album
                        $category->addPhoto($photo);
                        $entityManager->persist($photo);
                    }
                }
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_admin_category_show', ['id' => $category->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/category/new.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_category_show', methods: ['GET'])]
    public function show(Category $category): Response
    {
        $photos = $category->getPhotos();

        return $this->render('admin/category/show.html.twig', [
            'category' => $category,
            'photos' => $photos,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFiles = $form->get('newPhotos')->getData(); // get the first element
            foreach ($uploadedFiles as $uploadedFile) {
                if (!empty($uploadedFile)) {
                    $imageFileArray = $uploadedFile->getImageFileArray();
                    foreach ($imageFileArray as $imageFile) {
                        $photo = new Photo();

                        $photo->setImageFile($imageFile);
                        $photo->setCreatedAt(new \DateTimeImmutable());
                        $photo->setUpdatedAt(new \DateTimeImmutable());

                        // Ajouter la photo à l'album
                        $category->addPhoto($photo);
                        $entityManager->persist($photo);
                    }
                }
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_admin_category_show', ['id' => $category->getId()], Response::HTTP_SEE_OTHER);
        }
        $photos = $category->getPhotos();

        return $this->render('admin/category/edit.html.twig', [
            'category' => $category,
            'form' => $form,
            'photos' => $photos,
        ]);
    }

    private function removeDir(string $dir): void
    {
        $it = new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new \RecursiveIteratorIterator(
            $it,
            \RecursiveIteratorIterator::CHILD_FIRST
        );
        foreach ($files as $file) {
            if ($file->isDir()) {
                rmdir($file->getPathname());
            } else {
                unlink($file->getPathname());
            }
        }
        rmdir($dir);
    }

    #[Route('/{id}/delete', name: 'app_admin_category_delete', methods: ['POST'])]
    public function delete(Request $request, Category $category, EntityManagerInterface $entityManager, ParameterBagInterface $parameterBag): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            if (count($category->getPhotos()) > 0) {
                $this->removeDir($parameterBag->get('kernel.project_dir').'/public/photos/public/'.strtoupper($category->getUniqId()));
            }
            $category->setFavoritePhoto(null);
            $entityManager->remove($category);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_category_index');
    }

    #[Route('/{id}/update/favorite', name: 'app_admin_category_update_favorite', methods: ['POST'])]
    public function update_favorite_photo(Request $request, Category $category, EntityManagerInterface $entityManager)
    {
        $photoId = $request->request->get('photoId');
        $photo = null;

        // Si l'identifiant de la photo n'est pas nul, cherchez la photo correspondante
        if (null !== $photoId) {
            $photo = $entityManager->getRepository(Photo::class)->find($photoId);
            if (null !== $photo) {
                if ((null === $photo->getCategory()) || ($photo->getCategory()->getId() !== $category->getId())) {
                    // Si la photo n'appartient pas à la catégorie, retourner une erreur
                    return new Response('La photo spécifiée n\'appartient pas à cette catégorie', Response::HTTP_BAD_REQUEST);
                }
            }
        }

        $category->setFavoritePhoto($photo);
        $entityManager->flush();

        // Return a response with the photoId
        return new Response($photoId);
    }
}
