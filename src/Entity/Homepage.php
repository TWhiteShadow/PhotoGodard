<?php

namespace App\Entity;

use App\Repository\HomepageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HomepageRepository::class)]
class Homepage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $photoTopLeft = null;

    #[ORM\Column(length: 255)]
    private ?string $photoMiddle = null;

    #[ORM\Column(length: 255)]
    private ?string $photoBottom = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $subtitle = null;

    #[ORM\Column(length: 255)]
    private ?string $pfp = null;

    #[ORM\Column(length: 255)]
    private ?string $descriptionTitle = null;

    #[ORM\Column(length: 1028)]
    private ?string $descriptionText = null;

    #[ORM\Column(length: 1028)]
    private ?string $contactDescription = null;

    #[ORM\Column(length: 255)]
    private ?string $contactNumber = null;

    #[ORM\Column(length: 1028)]
    private ?string $contactLocation = null;

    #[ORM\Column(length: 255)]
    private ?string $contactEmail = null;

    #[ORM\Column(length: 255)]
    private ?string $contactPhotoTopRight = null;

    #[ORM\Column(length: 255)]
    private ?string $contactPhotoBottomRight = null;

    #[ORM\Column(length: 255)]
    private ?string $contactPhotoBottomLeft = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhotoTopLeft(): ?string
    {
        return $this->photoTopLeft;
    }

    public function setPhotoTopLeft(?string $photoTopLeft): static
    {
        $this->photoTopLeft = $photoTopLeft;

        return $this;
    }

    public function getPhotoMiddle(): ?string
    {
        return $this->photoMiddle;
    }

    public function setPhotoMiddle(?string $photoMiddle): static
    {
        $this->photoMiddle = $photoMiddle;

        return $this;
    }

    public function getPhotoBottom(): ?string
    {
        return $this->photoBottom;
    }

    public function setPhotoBottom(?string $photoBottom): static
    {
        $this->photoBottom = $photoBottom;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(string $subtitle): static
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function getPfp(): ?string
    {
        return $this->pfp;
    }

    public function setPfp(?string $pfp): static
    {
        $this->pfp = $pfp;

        return $this;
    }

    public function getDescriptionTitle(): ?string
    {
        return $this->descriptionTitle;
    }

    public function setDescriptionTitle(string $descriptionTitle): static
    {
        $this->descriptionTitle = $descriptionTitle;

        return $this;
    }

    public function getDescriptionText(): ?string
    {
        return $this->descriptionText;
    }

    public function setDescriptionText(string $descriptionText): static
    {
        $this->descriptionText = $descriptionText;

        return $this;
    }

    public function getContactDescription(): ?string
    {
        return $this->contactDescription;
    }

    public function setContactDescription(string $contactDescription): static
    {
        $this->contactDescription = $contactDescription;

        return $this;
    }

    public function getContactNumber(): ?string
    {
        return $this->contactNumber;
    }

    public function setContactNumber(string $contactNumber): static
    {
        $this->contactNumber = $contactNumber;

        return $this;
    }

    public function getContactLocation(): ?string
    {
        return $this->contactLocation;
    }

    public function setContactLocation(string $contactLocation): static
    {
        $this->contactLocation = $contactLocation;

        return $this;
    }

    public function getContactEmail(): ?string
    {
        return $this->contactEmail;
    }

    public function setContactEmail(string $contactEmail): static
    {
        $this->contactEmail = $contactEmail;

        return $this;
    }

    public function getContactPhotoTopRight(): ?string
    {
        return $this->contactPhotoTopRight;
    }

    public function setContactPhotoTopRight(?string $contactPhotoTopRight): static
    {
        $this->contactPhotoTopRight = $contactPhotoTopRight;

        return $this;
    }

    public function getContactPhotoBottomRight(): ?string
    {
        return $this->contactPhotoBottomRight;
    }

    public function setContactPhotoBottomRight(?string $contactPhotoBottomRight): static
    {
        $this->contactPhotoBottomRight = $contactPhotoBottomRight;

        return $this;
    }

    public function getContactPhotoBottomLeft(): ?string
    {
        return $this->contactPhotoBottomLeft;
    }

    public function setContactPhotoBottomLeft(?string $contactPhotoBottomLeft): static
    {
        $this->contactPhotoBottomLeft = $contactPhotoBottomLeft;

        return $this;
    }
}
