<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evenement
 *
 * @ORM\Table(name="evenement", indexes={@ORM\Index(name="idArtiste", columns={"Id_Artiste"}), @ORM\Index(name="Id_Restaurant", columns={"Id_Restaurant"})})
 * @ORM\Entity
 */
class Evenement
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_Evenement", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEvenement;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom_Evenement", type="string", length=20, nullable=false)
     */
    private $nomEvenement;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="Date_Evenement", type="date", nullable=true)
     */
    private $dateEvenement;

    /**
     * @var \Artiste
     *
     * @ORM\ManyToOne(targetEntity="Artiste")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_Artiste", referencedColumnName="Id_Artiste")
     * })
     */
    private $idArtiste;

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
