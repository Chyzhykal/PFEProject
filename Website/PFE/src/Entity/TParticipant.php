<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * TParticipant
 *
 * @ORM\Table(name="t_participant", uniqueConstraints={@ORM\UniqueConstraint(name="idParticipant_UNIQUE", columns={"idParticipant"})})
 * @ORM\Entity(repositoryClass="App\Repository\ParticipantRepository")
 */
class TParticipant
{
    /**
     * @var int
     *
     * @ORM\Column(name="idParticipant", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idparticipant;

    /**
     * @var string
     *
     * @ORM\Column(name="parFirstname", type="string", length=255, nullable=false)
     */
    private $parfirstname;

    /**
     * @var string
     *
     * @ORM\Column(name="parLastname", type="string", length=255, nullable=false)
     */
    private $parlastname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="parRole", type="string", length=45, nullable=true)
     */
    private $parrole;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="TEvent", mappedBy="fkparticipant")
     */
    private $fkevent;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkevent = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdparticipant(): ?int
    {
        return $this->idparticipant;
    }

    public function getParfirstname(): ?string
    {
        return $this->parfirstname;
    }

    public function setParfirstname(string $parfirstname): self
    {
        $this->parfirstname = $parfirstname;

        return $this;
    }

    public function getParlastname(): ?string
    {
        return $this->parlastname;
    }

    public function setParlastname(string $parlastname): self
    {
        $this->parlastname = $parlastname;

        return $this;
    }

    public function getParrole(): ?string
    {
        return $this->parrole;
    }

    public function setParrole(?string $parrole): self
    {
        $this->parrole = $parrole;

        return $this;
    }

    /**
     * @return Collection|TEvent[]
     */
    public function getFkevent(): Collection
    {
        return $this->fkevent;
    }

    public function addFkevent(TEvent $fkevent): self
    {
        if (!$this->fkevent->contains($fkevent)) {
            $this->fkevent[] = $fkevent;
            $fkevent->addFkparticipant($this);
        }

        return $this;
    }

    public function removeFkevent(TEvent $fkevent): self
    {
        if ($this->fkevent->contains($fkevent)) {
            $this->fkevent->removeElement($fkevent);
            $fkevent->removeFkparticipant($this);
        }

        return $this;
    }

}
