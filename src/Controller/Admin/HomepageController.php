<?php

namespace App\Controller\Admin;

use App\Entity\Homepage;
use App\Form\HomepageType;
use App\Message\UpdateHomepage;
use App\Repository\HomepageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Messenger\MessageBusInterface;

#[Route('/admin/homepage')]
class HomepageController extends AbstractController
{
    #[Route('/', name: 'app_admin_homepage_index', methods: ['GET'])]
    public function index(HomepageRepository $homepageRepository): Response
    {
        $ids = $homepageRepository->findAll();
        $id = $ids[0]->getId();

        return $this->redirectToRoute('app_admin_homepage_edit', ['id' => $id]);
    }

    #[Route('/new', name: 'app_admin_homepage_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $homepage = new Homepage();
        $form = $this->createForm(HomepageType::class, $homepage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // var_dump($request->files->get('homepage'));die;
            $imageFiles = $request->files->get('homepage');
            $uploadedImages = [];

            // Loop through each uploaded image
            foreach ($imageFiles as $fieldName => $uploadedFile) {
                /** @var UploadedFile $uploadedFile */
                if ($uploadedFile instanceof UploadedFile) {
                    $destination = $this->getParameter('kernel.project_dir').'/public/assets/images/';

                    // Generate unique filename
                    $newFilename = uniqid().'.'.$uploadedFile->guessExtension();

                    // Move the file to the directory where images are stored
                    $uploadedFile->move(
                        $destination,
                        $newFilename
                    );

                    // Store the path to the uploaded image
                    $uploadedImages[$fieldName] = '/assets/images/'.$newFilename;
                }
            }

            // Now you can use $uploadedImages array to store the paths in your entity or do other operations

            // Example: Storing paths in the entity
            $homepage->setPhotoTopLeft($uploadedImages['photoTopLeft']);
            $homepage->setPhotoMiddle($uploadedImages['photoMiddle']);
            $homepage->setPhotoBottom($uploadedImages['photoBottom']);
            $homepage->setPfp($uploadedImages['pfp']);
            $homepage->setContactPhotoTopRight($uploadedImages['contactPhotoTopRight']);
            $homepage->setContactPhotoBottomRight($uploadedImages['contactPhotoBottomRight']);
            $homepage->setContactPhotoBottomLeft($uploadedImages['contactPhotoBottomLeft']);

            // Set other image paths similarly

            $entityManager->persist($homepage);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_homepage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/homepage/new.html.twig', [
            'homepage' => $homepage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_homepage_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Homepage $homepage, MessageBusInterface $bus): Response
    {
        $defaultHomepage = clone $homepage;
        $form = $this->createForm(HomepageType::class, $homepage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle image upload
            $imageFiles = $request->files->get('homepage');
            $bus->dispatch(new UpdateHomepage($homepage, $defaultHomepage, $imageFiles));

            return $this->redirectToRoute('app_admin_homepage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/homepage/edit.html.twig', [
            'homepage' => $homepage,
            'form' => $form,
        ]);
    }
}
