<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Entity\User;

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
     * @Groups("publication1:read")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPublication;

    /**
     * @var string
     * @Assert\NotBlank
     * @Groups("publication1:read")
     * @ORM\Column(name="Libelle_Publication", type="string", length=255, nullable=false)
     *
     */
    private $libellePublication;

    /**
     * @var int
     * @Assert\NotBlank
     * @Groups("publication1:read")
     * @ORM\Column(name="Nb_Reaction", type="integer", nullable=false)
     *
     */
    private $nbReaction;

    /**
     * @var User
     * @Assert\NotBlank
     * @Groups("publication1:read")
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

    public function getNbReaction(): ?int
    {
        return $this->nbReaction;
    }

    public function setNbReaction(int $nbReaction): self
    {
        $this->nbReaction = $nbReaction;

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

    public function __toString()
    {
        return (string)$this->getIdPublication();
    }



}
