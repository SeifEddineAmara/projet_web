<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Reaction
 *
 * @ORM\Table(name="reaction", indexes={@ORM\Index(name="Id_Publication", columns={"Id_Publication"}), @ORM\Index(name="Id_User", columns={"Id_User"})})
 * @ORM\Entity
 */
class Reaction
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_Reaction", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idReaction;

    /**
     * @var int
     * @Assert\NotBlank
     * @ORM\Column(name="Type_Reaction", type="integer", nullable=false)
     */
    private $typeReaction;

    /**
     * @var \Publication
     * @Assert\NotBlank
     * @ORM\ManyToOne(targetEntity="Publication")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_Publication", referencedColumnName="Id_Publication")
     * })
     */
    private $idPublication;

    /**
     * @var \User
     * @Assert\NotBlank
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_User", referencedColumnName="id")
     * })
     */
    private $idUser;

    public function getIdReaction(): ?int
    {
        return $this->idReaction;
    }

    public function getTypeReaction(): ?int
    {
        return $this->typeReaction;
    }

    public function setTypeReaction(int $typeReaction): self
    {
        $this->typeReaction = $typeReaction;

        return $this;
    }

    public function getIdPublication(): ?Publication
    {
        return $this->idPublication;
    }

    public function setIdPublication(?Publication $idPublication): self
    {
        $this->idPublication = $idPublication;

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
