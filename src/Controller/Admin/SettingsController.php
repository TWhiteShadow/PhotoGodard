<?php

namespace App\Controller\Admin;

use App\Entity\Settings;
use App\Repository\SettingsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SettingsController extends AbstractController
{
    #[Route('/admin/show/{key}', name: 'app_admin_settings_show')]
    public function show(SettingsRepository $settingsRepository, string $key): JsonResponse
    {
        $setting = $settingsRepository->findOneBy(['settings_key' => $key]);
        if (empty($setting)) {
            throw $this->createNotFoundException('No settings found');
        }
        $jsonSettings = ['key' => $setting->getSettingsKey(), 'value' => $setting->getSettingsValue()];

        return new JsonResponse($jsonSettings);
    }

    #[Route('/admin/update/{key}', name: 'app_admin_settings_update', methods: ['POST'])]
    public function update(EntityManagerInterface $entityManager, SettingsRepository $settingsRepository, Request $request, string $key): Response
    {
        $data = json_decode($request->getContent(), true);
        $setting = $settingsRepository->findOneBy(['settings_key' => $key]);
        if (empty($setting)) {
            return new Response('error', Response::HTTP_NOT_FOUND);
        }
        $setting->setSettingsValue($data['lastScreenDate']);
        $entityManager->persist($setting);
        $entityManager->flush();

        return new Response('success', Response::HTTP_OK);
    }

    // #[Route('/admin/create/{setting}/{value}', name: 'app_admin_settings_create')]
    // public function create(Settings $setting, SettingsRepository $settingsRepository, Request $request): Response
    // {
    //     $settingsRepository->create($setting);

    //     // return $this->redirectToRoute('app_admin');
    // }
}
