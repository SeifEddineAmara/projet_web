<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Evenement
 *
 * @ORM\Table(name="evenement", indexes={@ORM\Index(name="idArtiste", columns={"Id_Artiste"}), @ORM\Index(name="Id_Restaurant", columns={"Id_Restaurant"})})
 * @ORM\Entity(repositoryClass=EvenementRepository::class)
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
     * @Assert\NotBlank(message="Nom est obligatoire")
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
     * @var Artiste
     *
     * @ORM\ManyToOne(targetEntity="Artiste")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_Artiste", referencedColumnName="Id_Artiste")
     * })
     */
    private $Artiste;

    /**
     * @var Restaurant
     *
     * @ORM\ManyToOne(targetEntity="Restaurant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_Restaurant", referencedColumnName="id")
     * })
     */
    private $Restaurant;

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
    public function getNomEvenement(): ?string
    {
        return $this->nomEvenement;
    }

    /**
     * @param string $nomEvenement
     */
    public function setNomEvenement(?string $nomEvenement): void
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
     * @return Artiste
     */
    public function getArtiste(): ?Artiste
    {
        return $this->Artiste;
    }

    /**
     * @param Artiste $Artiste
     */
    public function setArtiste(?Artiste $Artiste): void
    {
        $this->Artiste = $Artiste;
    }

    /**
     * @return Restaurant
     */
    public function getRestaurant(): ?Restaurant
    {
        return $this->Restaurant;
    }

    /**
     * @param Restaurant $Restaurant
     */
    public function setRestaurant(?Restaurant $Restaurant): void
    {
        $this->Restaurant = $Restaurant;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->nomEvenement;
    }


}
