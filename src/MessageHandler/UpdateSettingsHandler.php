<?php

namespace App\MessageHandler;

use App\Entity\Settings;
use App\Message\UpdateSettings;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class UpdateSettingsHandler
{
    private Settings $setting;
    private $data;

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function __invoke(UpdateSettings $command)
    {
        $this->setting = $command->getSetting();
        $this->data = $command->getData();
        $this->update();
        $this->entityManager->flush();
    }

    private function update()
    {
        if (empty($this->data)) {
            return;
        }
        $this->setting->setSettingsValue($this->data['lastScreenDate']);
        $this->entityManager->persist($this->setting);
    }
}
