<?php

namespace App\Entity;

use App\Repository\AlbumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AlbumRepository::class)]
class Album
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length:125)]
    private ?string $uniqId = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 512)]
    private ?string $password = null;

    private ?array $passwordArray = null;

    #[ORM\OneToMany(targetEntity: Photo::class, mappedBy: 'album')]
    #[ORM\JoinColumn(nullable: true, onDelete: "CASCADE")]
    private ?Collection $photos;


    public function __construct()
    {
        $this->photos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUniqId() : ?string
    {
        return $this->uniqId;
    }

    public function setUniqId() : static
    {
        $this->uniqId = uniqid();
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }
    public function getPasswordArray():?array
    {
        return $this->passwordArray;
    }
    public function setPasswordArray(?array $passwordArray): static
    {
        $this->passwordArray = $passwordArray;
        $this->password = $passwordArray['password'];

        return $this;
    }

    /**
     * @return Collection<int, Photo>
     */
    public function getPhotos(): ?Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): static
    {
        if (!$this->photos->contains($photo)) {
            $this->photos->add($photo);
            $photo->setAlbum($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): static
    {
        if ($this->photos->removeElement($photo)) {
            $photo->setAlbum(null);
        }

        return $this;
    }
}
