<?php

namespace App\MessageHandler;

use App\Message\UpdateVisibilityFooterLink;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class UpdateVisibilityFooterLinkHandler
{
    private $entityManager;
    private $footerLink;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(UpdateVisibilityFooterLink $command): void
    {
        $this->footerLink = $command->getFooterLink();
        $this->updateVisibility();
    }

    private function updateVisibility(): void
    {
        if ($this->footerLink->isVisible()) {
            $this->footerLink->setVisible(0);
        } else {
            $this->footerLink->setVisible(1);
        }
        $this->entityManager->persist($this->footerLink);
        $this->entityManager->flush();
    }
}
