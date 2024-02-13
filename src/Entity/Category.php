<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(length: 125)]
    private ?string $uniqId = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: Photo::class, cascade: ['remove'])]
    #[ORM\JoinColumn(name: 'favorite_photo_id', referencedColumnName: 'id', onDelete: 'SET NULL', nullable: true)]
    private ?Photo $favoritePhoto = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Photo::class, cascade:['remove'])]
    private Collection $photos;

    public function __construct()
    {
        $this->photos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUniqId(): ?string
    {
        return $this->uniqId;
    }

    public function setUniqId(): static
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

    public function getFavoritePhoto():?Photo
    {
        return $this->favoritePhoto; 
    }
    public function setFavoritePhoto(?Photo $favoritePhoto): static
    {
        $this->favoritePhoto = $favoritePhoto;

        return $this;
    }

    /**
     * @return Collection<int, Photo>
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): static
    {
        if (!$this->photos->contains($photo)) {
            $this->photos->add($photo);
            $photo->setCategory($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): static
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getCategory() === $this) {
                $photo->setCategory(null);
            }
        }

        return $this;
    }
}
