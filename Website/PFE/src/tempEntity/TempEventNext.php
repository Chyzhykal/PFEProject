<?php

namespace App\tempEntity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\TUser;
use App\Entity\TEvent;
/**
 * TempEventNext
 *
 * 
 */
class TempEventNext
{

    /**
     * @var TEvent
     *
     */
    private $relatedEvent;

    /**
     * @var int
     *
     */
    private $relatedActivityId;

    /**
     * @var bool
     *
     */
    private $eventSuite;

    public function getRelatedEvent(): ?TEvent
    {
        return $this->relatedEvent;
    }

    public function setRelatedEvent(TEvent $relatedEvent): self
    {
        $this->relatedEvent = $relatedEvent;
        
        return $this;
    }

    public function getRelatedActivityId(): ?int
    {
        return $this->relatedActivityId;
    }

    public function setRelatedActivityId(int $relatedActivityId): self
    {
        $this->relatedActivityId = $relatedActivityId;

        return $this;
    }

    public function getEventSuite(): ?bool
    {
        return $this->eventSuite;
    }

    public function setEventSuite(bool $eventSuite): self
    {
        $this->eventSuite = $eventSuite;

        return $this;
    }
}
