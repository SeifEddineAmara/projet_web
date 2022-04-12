<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     *
     * @ORM\Column(name="Type_Table", type="integer", nullable=false)
     */
    private $typeTable;

    /**
     * @var \Restaurant
     *
     * @ORM\ManyToOne(targetEntity="Restaurant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_Restaurant", referencedColumnName="id")
     * })
     */
    private $idRestaurant;


}
