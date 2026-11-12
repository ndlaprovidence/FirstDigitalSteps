<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $path = null;

    /**
     * @var Collection<int, Question>
     */
    #[ORM\ManyToMany(targetEntity: Question::class, inversedBy: 'images')]
    private Collection $Question;

    #[ORM\ManyToOne(inversedBy: 'Image')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Credit $credit = null;

    /**
     * @var Collection<int, SlideShow>
     */
    #[ORM\ManyToMany(targetEntity: SlideShow::class, mappedBy: 'Image')]
    private Collection $slideShows;

    /**
     * @var Collection<int, Slide>
     */
    #[ORM\ManyToMany(targetEntity: Slide::class, mappedBy: 'Image')]
    private Collection $slides;

    public function __construct()
    {
        $this->Question = new ArrayCollection();
        $this->slideShows = new ArrayCollection();
        $this->slides = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): static
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return Collection<int, Question>
     */
    public function getQuestion(): Collection
    {
        return $this->Question;
    }

    public function addQuestion(Question $question): static
    {
        if (!$this->Question->contains($question)) {
            $this->Question->add($question);
        }

        return $this;
    }

    public function removeQuestion(Question $question): static
    {
        $this->Question->removeElement($question);

        return $this;
    }

    public function getCredit(): ?Credit
    {
        return $this->credit;
    }

    public function setCredit(?Credit $credit): static
    {
        $this->credit = $credit;

        return $this;
    }

    /**
     * @return Collection<int, SlideShow>
     */
    public function getSlideShows(): Collection
    {
        return $this->slideShows;
    }

    public function addSlideShow(SlideShow $slideShow): static
    {
        if (!$this->slideShows->contains($slideShow)) {
            $this->slideShows->add($slideShow);
            $slideShow->addImage($this);
        }

        return $this;
    }

    public function removeSlideShow(SlideShow $slideShow): static
    {
        if ($this->slideShows->removeElement($slideShow)) {
            $slideShow->removeImage($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Slide>
     */
    public function getSlides(): Collection
    {
        return $this->slides;
    }

    public function addSlide(Slide $slide): static
    {
        if (!$this->slides->contains($slide)) {
            $this->slides->add($slide);
            $slide->addImage($this);
        }

        return $this;
    }

    public function removeSlide(Slide $slide): static
    {
        if ($this->slides->removeElement($slide)) {
            $slide->removeImage($this);
        }

        return $this;
    }
}
