<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Plat
 *
 * @ORM\Table(name="plat", indexes={@ORM\Index(name="fk1_plat_menu1", columns={"menu"})})
 * @ORM\Entity
 */
class Plat
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var string
     * @Assert\NotBlank
     * @ORM\Column(name="element", type="string", length=255, nullable=false)
     */
    private $element;

    /**
     * @var Menu
     * @Assert\NotBlank
     * @ORM\ManyToOne(targetEntity="Menu")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="menu", referencedColumnName="id")
     * })
     */
    private $menu;

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

    public function getElement(): ?string
    {
        return $this->element;
    }

    public function setElement(string $element): self
    {
        $this->element = $element;

        return $this;
    }

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

        return $this;
    }

    public function __toString()
    {
        return $this->getNom();
    }


}
