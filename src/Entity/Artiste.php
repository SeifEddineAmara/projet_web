<?php

namespace App\Entity;

use App\Repository\ArtisteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Artiste
 *
 * @ORM\Table(name="artiste")
 * @ORM\Entity(repositoryClass=ArtisteRepository::class)
 */
class Artiste
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_Artiste", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idArtiste;

    /**
     * @var string|null
     * @Assert\NotBlank(message="Nom est obligatoire")
     *
     * @ORM\Column(name="Nom_Artiste", type="string", length=30, nullable=true)
     */
    private $nomArtiste;

    /**
     * @var TypeDeMusique
     * @Assert\NotBlank(message="Genre de musique est obligatoire")
     *
     * @ORM\ManyToOne(targetEntity="TypeDeMusique")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Type_De_Musique", referencedColumnName="id")
     * })
     */
    private $typeDeMusique;

    /**
     * @return int
     */
    public function getIdArtiste(): int
    {
        return $this->idArtiste;
    }

    /**
     * @param int $idArtiste
     */
    public function setIdArtiste(int $idArtiste): void
    {
        $this->idArtiste = $idArtiste;
    }

    /**
     * @return string|null
     */
    public function getNomArtiste(): ?string
    {
        return $this->nomArtiste;
    }

    /**
     * @param string|null $nomArtiste
     */
    public function setNomArtiste(?string $nomArtiste): void
    {
        $this->nomArtiste = $nomArtiste;
    }

    /**
     * @return TypeDeMusique
     */
    public function getTypeDeMusique(): ?TypeDeMusique
    {
        return $this->typeDeMusique;
    }

    /**
     * @param TypeDeMusique $typeDeMusique
     */
    public function setTypeDeMusique(?TypeDeMusique $typeDeMusique): void
    {
        $this->typeDeMusique = $typeDeMusique;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->nomArtiste;
    }


}
