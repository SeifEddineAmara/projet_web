<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * TableRestaurant
 *
 * @ORM\Table(name="table_restaurant", indexes={@ORM\Index(name="Id_Restaurent", columns={"Id_Restaurant"})})
 * @ORM\Entity
 */
class TableRestaurant implements JsonSerializable
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
     *
     * @ORM\Column(name="Type_Table", type="integer", nullable=false)
     */
    private $typeTable;

    /**
     * @var int
     *
     * @ORM\Column(name="Id_Restaurant", type="integer", nullable=false)
     */
    private $idRestaurant;

    public function getIdTable(): ?int
    {
        return $this->idTable;
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

    public function getIdRestaurant(): ?int
    {
        return $this->idRestaurant;
    }

    public function setIdRestaurant(int $idRestaurant): self
    {
        $this->idRestaurant = $idRestaurant;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return array(
            'id' => $this->idRestaurant,
            'type' => $this->typeTable,
            'restaurant' => $this->idRestaurant
        );
    }

    public function setUp($type, $restaurant)
    {
        $this->typeTable = $type;
        $this->idRestaurant = $restaurant;
    }

    public function __toString() :string {
        return $this->getTypeTable();
    }
}
