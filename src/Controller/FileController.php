<?php

namespace App\Controller;

use App\Repository\PhotoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\ResponseInterface;

class FileController extends AbstractController
{

    #[Route('/file/{title}', 'app_file')]
    public function example(string $title, PhotoRepository $photoRepository): Response
    {

        // Obtenez le chemin absolu vers le répertoire des images privées
        $privateImagesDir = $this->getParameter('kernel.project_dir') . '/storage/images/private';
        $photo = $photoRepository->findOneBy(['title' => $title]);
        $album = strtoupper($photo->getAlbum()->getUniqId());

        // Concaténez le chemin du fichier spécifique que vous souhaitez charger
        $filePath = $privateImagesDir . '/' . $album . "/" . $photo->getFilename();

        // Créez une instance de Symfony\Component\HttpFoundation\File\File
        $file = file_get_contents($filePath);
        $file = new Response($file, 200);

        // Vous pouvez maintenant utiliser $file comme réponse pour envoyer le fichier
        return $file;
    }
}