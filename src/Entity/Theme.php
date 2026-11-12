<?php

namespace App\Entity;

use App\Repository\ThemeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ThemeRepository::class)]
#[ORM\Table(name: 'tbl_theme')]
class Theme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    /**
     * @var Collection<int, Question>
     */
    #[ORM\OneToMany(targetEntity: Question::class, mappedBy: 'theme', orphanRemoval: true)]
    private Collection $questions;

    /**
     * @var Collection<int, SlideShow>
     */
    #[ORM\OneToMany(targetEntity: SlideShow::class, mappedBy: 'Theme')]
    private Collection $slideShows;



    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->slideShows = new ArrayCollection();
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
     * @return Collection<int, Question>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): static
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
            $question->setTheme($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): static
    {
        if ($this->questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getTheme() === $this) {
                $question->setTheme(null);
            }
        }

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
            $slideShow->setTheme($this);
        }

        return $this;
    }

    public function removeSlideShow(SlideShow $slideShow): static
    {
        if ($this->slideShows->removeElement($slideShow)) {
            // set the owning side to null (unless already changed)
            if ($slideShow->getTheme() === $this) {
                $slideShow->setTheme(null);
            }
        }

        return $this;
    }

}
