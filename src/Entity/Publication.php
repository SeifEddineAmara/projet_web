<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Publication
 *
 * @ORM\Table(name="publication", indexes={@ORM\Index(name="Id_User", columns={"Id_User"})})
 * @ORM\Entity
 */
class Publication
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_Publication", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPublication;

    /**
     * @var string
     *
     * @ORM\Column(name="Libelle_Publication", type="string", length=255, nullable=false)
     */
    private $libellePublication;

    /**
     * @var int
     *
     * @ORM\Column(name="Nb_RÃ©action", type="integer", nullable=false)
     */
    private $nbRã©action;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_User", referencedColumnName="id")
     * })
     */
    private $idUser;

    public function getIdPublication(): ?int
    {
        return $this->idPublication;
    }

    public function getLibellePublication(): ?string
    {
        return $this->libellePublication;
    }

    public function setLibellePublication(string $libellePublication): self
    {
        $this->libellePublication = $libellePublication;

        return $this;
    }

    public function getNbRã©action(): ?int
    {
        return $this->nbRã©action;
    }

    public function setNbRã©action(int $nbRã©action): self
    {
        $this->nbRã©action = $nbRã©action;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }


}
