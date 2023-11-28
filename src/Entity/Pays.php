<?php

namespace App\Entity;

use App\Repository\PaysRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaysRepository::class)]
class Pays
{
    public function __toString(): string
    {
        return $this->nom;
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private $id;

    #[ORM\Column(type: "string", length: 255)]
    private $nom;

    #[ORM\OneToMany(mappedBy: 'pays', targetEntity: Film::class)]
    private Collection $film;

    #[ORM\OneToMany(mappedBy: 'pays', targetEntity: Realisateur::class)]
    private Collection $realisateur;

    #[ORM\OneToMany(mappedBy: 'pays', targetEntity: Acteur::class)]
    private Collection $acteur;

    public function __construct()
    {
        $this->film = new ArrayCollection();
        $this->realisateur = new ArrayCollection();
        $this->acteur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Film>
     */
    public function getFilm(): Collection
    {
        return $this->film;
    }

    public function addFilm(Film $film): self
    {
        if (!$this->film->contains($film)) {
            $this->film[] = $film;
            $film->setPays($this);
        }

        return $this;
    }

    public function removeFilm(Film $film): self
    {
        if ($this->film->removeElement($film)) {
            // set the owning side to null (unless already changed)
            if ($film->getPays() === $this) {
                $film->setPays(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Realisateur>
     */
    public function getRealisateur(): Collection
    {
        return $this->realisateur;
    }

    public function addRealisateur(Realisateur $realisateur): self
    {
        if (!$this->realisateur->contains($realisateur)) {
            $this->realisateur[] = $realisateur;
            $realisateur->setPays($this);
        }

        return $this;
    }

    public function removeRealisateur(Realisateur $realisateur): self
    {
        if ($this->realisateur->removeElement($realisateur)) {
            // set the owning side to null (unless already changed)
            if ($realisateur->getPays() === $this) {
                $realisateur->setPays(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Acteur>
     */
    public function getActeur(): Collection
    {
        return $this->acteur;
    }

    public function addActeur(Acteur $acteur): self
    {
        if (!$this->acteur->contains($acteur)) {
            $this->acteur[] = $acteur;
            $acteur->setPays($this);
        }

        return $this;
    }

    public function removeActeur(Acteur $acteur): self
    {
        if ($this->acteur->removeElement($acteur)) {
            // set the owning side to null (unless already changed)
            if ($acteur->getPays() === $this) {
                $acteur->setPays(null);
            }
        }

        return $this;
    }
}
