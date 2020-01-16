<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TEventMerge
 * 
 * @ORM\Entity(repositoryClass="App\Repository\TEventMergeRepository")
 * @ORM\Table(name="t_eventMerge", uniqueConstraints={@ORM\UniqueConstraint(name="idmerge_UNIQUE", columns={"idMerge"})}, indexes={
 * @ORM\Index(name="fk_t_eventMerge_t_event_id1", columns={"fkEvent1"}), 
 * @ORM\Index(name="fk_t_eventMerge_t_event_id2", columns={"fkEvent2"}), 
 * })
 */
class TEventMerge
{
    /**
     *  @var int
     *
     * @ORM\Column(name="idMerge", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idmerge;

    /**
     * @var TEvent
     *
     * @ORM\ManyToOne(targetEntity="TEvent")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fkEvent1", referencedColumnName="idEvent")
     * })
     */
    private $fkevent1;

    /**
     * @var TEvent
     *
     * @ORM\ManyToOne(targetEntity="TEvent")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fkEvent2", referencedColumnName="idEvent")
     * })
     */
    private $fkevent2;

    public function getIdmerge(): ?int
    {
        return $this->idmerge;
    }

    public function getFkevent1(): ?TEvent
    {
        return $this->fkevent1;
    }

    public function setFkevent1(TEvent $fkevent1): self
    {
        $this->fkevent1 = $fkevent1;

        return $this;
    }

    public function getFkevent2(): ?TEvent
    {
        return $this->fkevent2;
    }

    public function setFkEvent2(TEvent $fkevent2): self
    {
        $this->fkevent2 = $fkevent2;

        return $this;
    }
}
