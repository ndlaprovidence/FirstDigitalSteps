<?php

namespace App\Entity;

use App\Repository\CreditRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CreditRepository::class)]
class Credit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $Auteur = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Lien_source = null;

    /**
     * @var Collection<int, Image>
     */
    #[ORM\OneToMany(targetEntity: Image::class, mappedBy: 'credit', orphanRemoval: true)]
    private Collection $Image;

    public function __construct()
    {
        $this->Image = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuteur(): ?string
    {
        return $this->Auteur;
    }

    public function setAuteur(string $Auteur): static
    {
        $this->Auteur = $Auteur;

        return $this;
    }

    public function getLienSource(): ?string
    {
        return $this->Lien_source;
    }

    public function setLienSource(?string $Lien_source): static
    {
        $this->Lien_source = $Lien_source;

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
            $image->setCredit($this);
        }

        return $this;
    }

    public function removeImage(Image $image): static
    {
        if ($this->Image->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getCredit() === $this) {
                $image->setCredit(null);
            }
        }

        return $this;
    }
}
