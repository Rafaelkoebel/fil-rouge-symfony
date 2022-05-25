<?php

namespace App\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use App\Repository\SujetRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SujetRepository::class)]
class Sujet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $titre;

    /**
    * @gedmo\Slug(fields={"titre"})
    */
    #[ORM\Column(type: 'string', length: 255)]
    private $slug;

    #[ORM\Column(type: 'text')]
    private $contenu;

    /**
     * @Gedmo\Timestampable(on="create")
     */
    #[ORM\Column(type: 'datetime')]
    private $date_publication;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: 'sujets')]
    #[ORM\JoinColumn(nullable: false)]
    private $utilisateur;

    #[ORM\ManyToOne(targetEntity: Categorie::class, inversedBy: 'sujets')]
    #[ORM\JoinColumn(nullable: false)]
    private $categorie;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getDatePublication(): ?\DateTimeInterface
    {
        return $this->date_publication;
    }

    // public function setDatePublication(\DateTimeInterface $date_publication): self
    // {
    //     $this->date_publication = $date_publication;

    //     return $this;
    // }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    // public function setSlug(string $slug): self
    // {
    //     $this->slug = $slug;

    //     return $this;
    // }
}
