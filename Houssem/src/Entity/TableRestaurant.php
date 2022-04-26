<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * TableRestaurant
 *
 * @ORM\Table(name="table_restaurant", indexes={@ORM\Index(name="Id_Restaurent", columns={"Id_Restaurant"})})
 * @ORM\Entity
 */
class TableRestaurant
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_Table", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTable;

    /**
     * @var int
     * @Assert\NotBlank
     * @ORM\Column(name="Type_Table", type="integer", nullable=false)
     */
    private $typeTable;

    /**
     * @var \Restaurant
     * @Assert\NotBlank
     * @ORM\ManyToOne(targetEntity="Restaurant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_Restaurant", referencedColumnName="id")
     * })
     */
    private $idRestaurant;

    public function getIdTable(): ?int
    {
        return $this->idTable.$this->typeTable;
    }

    public function getTypeTable(): ?int
    {
        return $this->typeTable;
    }

    public function setTypeTable(int $typeTable): self
    {
        $this->typeTable = $typeTable;

        return $this;
    }

    public function getIdRestaurant(): ?Restaurant
    {
        return $this->idRestaurant;
    }

    public function setIdRestaurant(?Restaurant $idRestaurant): self
    {
        $this->idRestaurant = $idRestaurant;

        return $this;
    }

    public function __toString() :string {
        return $this->getIdRestaurant()->getNom();
    }


}
