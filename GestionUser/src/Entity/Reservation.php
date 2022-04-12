<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation", indexes={@ORM\Index(name="Id_Table", columns={"Id_Table"}), @ORM\Index(name="Id_Resaturent", columns={"Id_Restaurant"}), @ORM\Index(name="Id_User", columns={"Id_User"})})
 * @ORM\Entity
 */
class Reservation
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_Reservation", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idReservation;

    /**
     * @var int
     *
     * @ORM\Column(name="Heure", type="integer", nullable=false)
     */
    private $heure;

    /**
     * @var string
     *
     * @ORM\Column(name="Date", type="string", length=225, nullable=false)
     */
    private $date;

    /**
     * @var \Restaurant
     *
     * @ORM\ManyToOne(targetEntity="Restaurant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_Restaurant", referencedColumnName="id")
     * })
     */
    private $idRestaurant;

    /**
     * @var \TableRestaurant
     *
     * @ORM\ManyToOne(targetEntity="TableRestaurant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_Table", referencedColumnName="Id_Table")
     * })
     */
    private $idTable;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_User", referencedColumnName="id")
     * })
     */
    private $idUser;


}
