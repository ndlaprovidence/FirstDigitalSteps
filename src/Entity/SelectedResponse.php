<?php

namespace App\Entity;

use App\Repository\SelectedResponseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SelectedResponseRepository::class)]
#[ORM\Table(name: 'tbl_selected_response')]
class SelectedResponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $selected_answer_X_time = null;

    #[ORM\ManyToOne(inversedBy: 'selectedResponses')]
    private ?Statistic $statistic = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Response $response = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSelectedAnswerXTime(): ?int
    {
        return $this->selected_answer_X_time;
    }

    public function setSelectedAnswerXTime(?int $selected_answer_X_time): static
    {
        $this->selected_answer_X_time = $selected_answer_X_time;

        return $this;
    }

    public function getStatistic(): ?Statistic
    {
        return $this->statistic;
    }

    public function setStatistic(?Statistic $statistic): static
    {
        $this->statistic = $statistic;

        return $this;
    }

    public function getResponse(): ?Response
    {
        return $this->response;
    }

    public function setResponse(?Response $response): static
    {
        $this->response = $response;

        return $this;
    }
}
