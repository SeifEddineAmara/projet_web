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

    /**
     * @param string $nomEvenement
     * @param \DateTime|null $dateEvenement
     * @param \Artiste $idArtiste
     * @param \Restaurant $idRestaurant
     */
    public function __construct(string $nomEvenement, ?\DateTime $dateEvenement, \Artiste $idArtiste, \Restaurant $idRestaurant)
    {
        $this->nomEvenement = $nomEvenement;
        $this->dateEvenement = $dateEvenement;
        $this->idArtiste = $idArtiste;
        $this->idRestaurant = $idRestaurant;
    }

    /**
     * @return int
     */
    public function getIdEvenement(): int
    {
        return $this->idEvenement;
    }

    /**
     * @param int $idEvenement
     */
    public function setIdEvenement(int $idEvenement): void
    {
        $this->idEvenement = $idEvenement;
    }

    /**
     * @return string
     */
    public function getNomEvenement(): string
    {
        return $this->nomEvenement;
    }

    /**
     * @param string $nomEvenement
     */
    public function setNomEvenement(string $nomEvenement): void
    {
        $this->nomEvenement = $nomEvenement;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateEvenement(): ?\DateTime
    {
        return $this->dateEvenement;
    }

    /**
     * @param \DateTime|null $dateEvenement
     */
    public function setDateEvenement(?\DateTime $dateEvenement): void
    {
        $this->dateEvenement = $dateEvenement;
    }

    /**
     * @return \Artiste
     */
    public function getIdArtiste(): \Artiste
    {
        return $this->idArtiste;
    }

    /**
     * @param \Artiste $idArtiste
     */
    public function setIdArtiste(\Artiste $idArtiste): void
    {
        $this->idArtiste = $idArtiste;
    }

    /**
     * @return \Restaurant
     */
    public function getIdRestaurant(): \Restaurant
    {
        return $this->idRestaurant;
    }

    /**
     * @param \Restaurant $idRestaurant
     */
    public function setIdRestaurant(\Restaurant $idRestaurant): void
    {
        $this->idRestaurant = $idRestaurant;
    }


}
