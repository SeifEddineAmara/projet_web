<?php

namespace App\Entity;

use App\Repository\TypeDeMusiqueRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypeDeMusiqueRepository::class)
 */
class TypeDeMusique
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank (message="Le genre doit avoir un nom")
     * @Assert\Unique
     *
     * @ORM\Column(type="string", unique=true, length=255)
     */
    private $Genre;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGenre(): ?string
    {
        return $this->Genre;
    }

    public function setGenre(string $Genre): self
    {
        $this->Genre = $Genre;

        return $this;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->Genre;
    }

}
