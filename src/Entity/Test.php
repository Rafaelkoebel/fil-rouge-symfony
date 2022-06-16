<?php

namespace App\Entity;

use App\Repository\TestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestRepository::class)]
class Test
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'string', length: 255)]
    private $prenom;

    // /**
    //  * @ORM\OneToMany(
    //  *     targetEntity="Test2",
    //  *     mappedBy="test",
    //  *     cascade={"persist"}
    //  * )
    //  */
    
    #[ORM\OneToMany(mappedBy: 'test', targetEntity: Test2::class)]
    private $test2s;

    public function __construct()
    {
        $this->test2s = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * @return Collection<int, Test2>
     */
    public function getTest2s(): Collection
    {
        return $this->test2s;
    }

    public function addTest2(Test2 $test2): self
    {
        if (!$this->test2s->contains($test2)) {
            $this->test2s[] = $test2;
            $test2->setTest($this);
        }

        return $this;
    }

    public function removeTest2(Test2 $test2): self
    {
        if ($this->test2s->removeElement($test2)) {
            // set the owning side to null (unless already changed)
            if ($test2->getTest() === $this) {
                $test2->setTest(null);
            }
        }

        return $this;
    }
}
