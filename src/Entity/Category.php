<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: PROGRAM::class)]
    private $programs;

    public function __construct(ArrayCollection $programs){}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrograms(): Collection
    {
        return $this->programs;
    }

    public function addProgram(Program $program): self
    {
        // si instance de category n'a pas de prog
        if (!$this->programs->contains($program)){
            //alors tableau program = param $program
            $this->programs[] = $program;
            // set la category sur l'instance actuelle
            $program->setCategory($this);
        }
        return $this;
    }

    public function revomeProgram(Program $program): self
    {
        // si je delete un element de la collection program
        if ($this->programs->removeElement($program)){
            // et qu'il fait partie la catégory de l'instance 
            if ($program->getCategory() === $this) {
                //alors je définis sa catégory sur null
                $program->setCategory(null);
            };
        };
        return $this;
    }
}
