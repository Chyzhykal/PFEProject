<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TEventMerge
 * Used for merges between events, for instance when event has multiple sequences
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
     * @ORM\OrderBy({"evebegintime" = "ASC"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fkEvent1", referencedColumnName="idEvent")
     * })
     */
    private $fkeventmaster;

    /**
     * @var TEvent
     *
     * @ORM\ManyToOne(targetEntity="TEvent")
     * @ORM\OrderBy({"evebegintime" = "ASC"})
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="fkEvent2", referencedColumnName="idEvent")
     * })
     * 
     */
    private $fkeventchild;

    public function getIdmerge(): ?int
    {
        return $this->idmerge;
    }

    public function getFkeventmaster(): ?TEvent
    {
        return $this->fkeventmaster;
    }

    public function setFkeventmaster(TEvent $fkeventmaster): self
    {
        $this->fkeventmaster = $fkeventmaster;

        return $this;
    }

    public function getFkeventchild(): ?TEvent
    {
        return $this->fkeventchild;
    }

    public function setFkEventchild(TEvent $fkeventchild): self
    {
        $this->fkeventchild = $fkeventchild;

        return $this;
    }
}
