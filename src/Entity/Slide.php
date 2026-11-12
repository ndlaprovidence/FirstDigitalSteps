<?php

namespace App\Entity;

use App\Repository\SlideRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SlideRepository::class)]
class Slide
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    /**
     * @var Collection<int, Image>
     */
    #[ORM\ManyToMany(targetEntity: Image::class, inversedBy: 'slides')]
    private Collection $Image;

    #[ORM\ManyToOne(inversedBy: 'slides')]
    private ?SlideShow $SlideShow = null;

    #[ORM\Column]
    private ?int $Position = null;

    public function __construct()
    {
        $this->Image = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, Image>
     */
    public function getImage(): Collection
    {
        return $this->Image;
    }

    public function addImage(Image $image): static
    {
        if (!$this->Image->contains($image)) {
            $this->Image->add($image);
        }

        return $this;
    }

    public function removeImage(Image $image): static
    {
        $this->Image->removeElement($image);

        return $this;
    }

    public function getSlideShow(): ?SlideShow
    {
        return $this->SlideShow;
    }

    public function setSlideShow(?SlideShow $SlideShow): static
    {
        $this->SlideShow = $SlideShow;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->Position;
    }

    public function setPosition(int $Position): static
    {
        $this->Position = $Position;

        return $this;
    }
}
