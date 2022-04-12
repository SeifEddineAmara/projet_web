<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Artiste
 *
 * @ORM\Table(name="artiste")
 * @ORM\Entity
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
     * @Assert\Length(
     *  min = 2,
     *  max = 30,
     *  minMessage = "Le nom doit avoir une longueur minimale de {{ limit }} caractères",
     *  maxMessage = "Le nom doit avoir une longueur maximale de {{ limit }} caractères",
     *)
     * @Assert\NotNull
     *
     * @ORM\Column(name="Nom_Artiste", type="string", length=30, nullable=true)
     */
    private $nomArtiste;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Type_De_Musique", type="string", length=20, nullable=true)
     */
    private $typeDeMusique;

    /**
     * @param string|null $nomArtiste
     * @param string|null $typeDeMusique
     */


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
     * @return string|null
     */
    public function getTypeDeMusique(): ?string
    {
        return $this->typeDeMusique;
    }

    /**
     * @param string|null $typeDeMusique
     */
    public function setTypeDeMusique(?string $typeDeMusique): void
    {
        $this->typeDeMusique = $typeDeMusique;
    }


}
