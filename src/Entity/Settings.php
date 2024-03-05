<?php

namespace App\Entity;

use App\Repository\SettingsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SettingsRepository::class)]
class Settings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $settings_key = null;

    #[ORM\Column(length: 2048, nullable: true)]
    private ?string $settings_value = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSettingsKey(): ?string
    {
        return $this->settings_key;
    }

    public function setSettingsKey(?string $settings_key): static
    {
        $this->settings_key = $settings_key;

        return $this;
    }

    public function getSettingsValue(): ?string
    {
        return $this->settings_value;
    }

    public function setSettingsValue(?string $settings_value): static
    {
        $this->settings_value = $settings_value;

        return $this;
    }
}
