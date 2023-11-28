<?php

namespace App\Entity;

use App\Repository\RealisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RealisateurRepository::class)]
class Realisateur
{
    public function __toString(): string
    {
        return $this->name;
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTimeInterface $nee = null;

    #[ORM\ManyToMany(targetEntity: Film::class, mappedBy: 'realisateur')]
    private Collection $film;

    #[ORM\ManyToOne(inversedBy: 'realisateur')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Pays $pays = null;

    public function __construct()
    {
        $this->film = new ArrayCollection();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getNee(): ?\DateTimeInterface
    {
        return $this->nee;
    }

    public function setNee(?\DateTimeInterface $nee): self
    {
        $this->nee = $nee;

        return $this;
    }

    public function getFilm(): Collection
    {
        return $this->film;
    }

    public function addFilm(Film $film): self
    {
        if (!$this->film->contains($film)) {
            $this->film[] = $film;
        }

        return $this;
    }

    public function removeFilm(Film $film): self
    {
        $this->film->removeElement($film);

        return $this;
    }

    public function getPays(): ?Pays
    {
        return $this->pays;
    }

    public function setPays(?Pays $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
