<?php

namespace App\Controller;

use App\Repository\PhotoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;

use function PHPUnit\Framework\throwException;

class FileController extends AbstractController
{
    #[Route('/file/{id}', 'app_file')]
    public function getFile(int $id, PhotoRepository $photoRepository, Session $session): Response
    {
        $photo = $photoRepository->find($id);
        $favoritePhoto = false; 
        if (empty($photo)) {
            throw $this->createNotFoundException('No photo found for id '.$id);
        }

        if($photo->getAlbum() === null){
            throw $this->createNotFoundException('The photo is not linked to an album');
        }
        if(!empty($photo->getAlbum()->getFavoritePhoto()) && $photo->getAlbum()->getFavoritePhoto()->getId() === $photo->getId()){
            $favoritePhoto = true; 
        }

        if($favoritePhoto === false){
            if(empty($this->getUser()) && empty($session->get('ROLE_ALBUM_ACCESS'))){
    
                throw new AccessDeniedHttpException('Accès refusé. Vous devez être connecté pour accéder à cette ressource.');
            }
            if(empty($this->getUser()) && (!empty($session->get('ROLE_ALBUM_ACCESS')) && $session->get('ROLE_ALBUM_ACCESS') !== $photo->getAlbum()->getUniqId() . '-ACCESS')){
                throw new AccessDeniedHttpException('Accès refusé. Vous devez être connecté pour accéder à cette ressource.');
            }
            if ((!empty($this->getUser()) && !in_array('ROLE_ADMIN', $this->getUser()->getRoles()))) {
                throw new AccessDeniedHttpException('Accès refusé. Vous devez être connecté pour accéder à cette ressource.');
            }
        }
        
        
        // Obtenez le chemin absolu vers le répertoire des images privées
        $privateImagesDir = $this->getParameter('kernel.project_dir').'/storage/images/private';
        $album = strtoupper($photo->getAlbum()->getUniqId());
        // Concaténez le chemin du fichier spécifique que vous souhaitez charger
        $filePath = $privateImagesDir.'/'.$album.'/'.$photo->getFilename();

        // Créez une instance de Symfony\Component\HttpFoundation\File\File
        $file = file_get_contents($filePath);
        $file = new Response($file, 200);

        // Vous pouvez maintenant utiliser $file comme réponse pour envoyer le fichier
        return $file;
    }
}
