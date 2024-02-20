<?php

namespace App\Controller\Admin;

use App\Entity\Album;
use App\Entity\Photo;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        $diskFreeSpace = disk_free_space("/");
        $diskTotalSpace = disk_total_space("/");

        // Convert bytes to gigabytes
        $diskFreeSpaceGB = $diskFreeSpace / (1024 * 1024 * 1024);
        $diskTotalSpaceGB = $diskTotalSpace / (1024 * 1024 * 1024);

        $availableDiskSpace = ($diskFreeSpaceGB / $diskTotalSpaceGB)*100;
        $usedDiskSpace = (($diskTotalSpaceGB - $availableDiskSpace)/ $diskTotalSpaceGB) * 100;

        return $this->render('admin/dashboard.html.twig', [
            'diskFreeSpace' => round($diskFreeSpaceGB, 2),
            'diskTotalSpace' => round($diskTotalSpaceGB,2),
            'availableDiskSpace' => round($availableDiskSpace, 2),
            'usedDiskSpace' => round($usedDiskSpace, 2),
        ]);
    }


}
