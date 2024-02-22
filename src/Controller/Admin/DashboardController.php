<?php

namespace App\Controller\Admin;

use App\Entity\Album;
use App\Entity\Photo;
use App\Repository\AlbumRepository;
use App\Repository\CategoryRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(AlbumRepository $albumRepository, CategoryRepository $categoryRepository): Response
    {
        $diskFreeSpace = disk_free_space("/");
        $diskTotalSpace = disk_total_space("/");

        // Convert bytes to gigabytes
        $diskFreeSpaceGB = $diskFreeSpace / (1024 * 1024 * 1024);
        $diskTotalSpaceGB = $diskTotalSpace / (1024 * 1024 * 1024);

        $availableDiskSpace = ($diskFreeSpaceGB / $diskTotalSpaceGB)*100;
        $usedDiskSpace = 100 - $availableDiskSpace;

        $allCategories = $categoryRepository->findAll();
        $numberOfCategories = count($allCategories);
        

        $allAlbums = $albumRepository->findAll();
        $numberOfAlbums = count($allAlbums);
        $numberOfPhotos = 0;

        foreach ($allAlbums as $album) {
            $numberOfPhotos += count($album->getPhotos());
        }

        foreach ($allCategories as $category) {
            $numberOfPhotos += count($category->getPhotos());
        }



        return $this->render('admin/dashboard.html.twig', [
            'diskFreeSpace' => round($diskFreeSpaceGB, 2),
            'diskTotalSpace' => round($diskTotalSpaceGB,2),
            'availableDiskSpace' => round($availableDiskSpace, 2),
            'usedDiskSpace' => round($usedDiskSpace, 2),
            'numberOfAlbums' => $numberOfAlbums,
            'numberOfCategories' => $numberOfCategories,
            'numberOfPhotos' => $numberOfPhotos,
        ]);
    }


}
