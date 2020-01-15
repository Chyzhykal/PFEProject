<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * * @ORM\Table(name="t_eventPriority", uniqueConstraints={@ORM\UniqueConstraint(name="idPriority_UNIQUE", columns={"idPriority"})})
 * @ORM\Entity(repositoryClass="App\Repository\TEventPriorityRepository")
 */
class TEventPriority
{

    /**
     * @ORM\Column(name="idPriority", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idpriority;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $evepriname;

     /**
     * @ORM\Column(type="integer")
     */
    private $evepricode;

    public function getIdPriority(): ?int
    {
        return $this->idpriority;
    }

    public function getEvepriname(): ?string
    {
        return $this->evepriname;
    }

    public function setEvepriname(string $evepriname): self
    {
        $this->evepriname = $evepriname;

        return $this;
    }

    public function getEvepricode(): ?int
    {
        return $this->evepricode;
    }

    public function setEvepricode(int $evepricode): self
    {
        $this->evepricode = $evepricode;

        return $this;
    }
}
