<?php

namespace App\Entity;

use App\Repository\StatisticRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatisticRepository::class)]
#[ORM\Table(name: 'tbl_statistic')]
class Statistic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $t_moyen = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $t_min = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $t_max = null;

    #[ORM\Column(nullable: true)]
    private ?int $question_asked_X_time_ = null;

    #[ORM\OneToOne(inversedBy: 'statistic', cascade: ['persist', 'remove'])]
    private ?Question $question = null;

    /**
     * @var Collection<int, SelectedResponse>
     */
    #[ORM\OneToMany(targetEntity: SelectedResponse::class, mappedBy: 'statistic')]
    private Collection $selectedResponses;

    public function __construct()
    {
        $this->selectedResponses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTMoyen(): ?string
    {
        return $this->t_moyen;
    }

    public function setTMoyen(?string $t_moyen): static
    {
        $this->t_moyen = $t_moyen;

        return $this;
    }

    public function getTMin(): ?string
    {
        return $this->t_min;
    }

    public function setTMin(?string $t_min): static
    {
        $this->t_min = $t_min;

        return $this;
    }

    public function getTMax(): ?string
    {
        return $this->t_max;
    }

    public function setTMax(?string $t_max): static
    {
        $this->t_max = $t_max;

        return $this;
    }

    public function getQuestionAskedXTime(): ?int
    {
        return $this->question_asked_X_time_;
    }

    public function setQuestionAskedXTime(?int $question_asked_X_time_): static
    {
        $this->question_asked_X_time_ = $question_asked_X_time_;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): static
    {
        $this->question = $question;

        return $this;
    }

    /**
     * @return Collection<int, SelectedResponse>
     */
    public function getSelectedResponses(): Collection
    {
        return $this->selectedResponses;
    }

    public function addSelectedResponse(SelectedResponse $selectedResponse): static
    {
        if (!$this->selectedResponses->contains($selectedResponse)) {
            $this->selectedResponses->add($selectedResponse);
            $selectedResponse->setStatistic($this);
        }

        return $this;
    }

    public function removeSelectedResponse(SelectedResponse $selectedResponse): static
    {
        if ($this->selectedResponses->removeElement($selectedResponse)) {
            // set the owning side to null (unless already changed)
            if ($selectedResponse->getStatistic() === $this) {
                $selectedResponse->setStatistic(null);
            }
        }

        return $this;
    }
}
