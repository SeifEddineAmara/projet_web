<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     *
     * @ORM\Column(name="Nom_Artiste", type="string", length=30, nullable=true, options={"default"="NULL"})
     */
    private $nomArtiste = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="Type_De_Musique", type="string", length=20, nullable=true, options={"default"="NULL"})
     */
    private $typeDeMusique = 'NULL';

    public function getIdArtiste(): ?int
    {
        return $this->idArtiste;
    }

    public function getNomArtiste(): ?string
    {
        return $this->nomArtiste;
    }

    public function setNomArtiste(?string $nomArtiste): self
    {
        $this->nomArtiste = $nomArtiste;

        return $this;
    }

    public function getTypeDeMusique(): ?string
    {
        return $this->typeDeMusique;
    }

    public function setTypeDeMusique(?string $typeDeMusique): self
    {
        $this->typeDeMusique = $typeDeMusique;

        return $this;
    }


}
