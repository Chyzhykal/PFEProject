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
     * @var \DateTime
     *
     */
    private $beginTime;

    /**
     * @var \DateTime
     *
     */
    private $endTime;


    public function getBeginTime(): ?\DateTime
    {
        return $this->beginTime;
    }

    public function setBeginTime(\DateTime $beginTime): self
    {
        $this->beginTime = $beginTime;

        return $this;
    }

    public function getEndTime(): ?\DateTime
    {
        return $this->endTime;
    }

    public function setEndTime(\DateTime $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function getRelatedEvent(): ?TEvent
    {
        return $this->relatedEvent;
    }

    public function setRelatedEvent(TEvent $relatedEvent): self
    {
        $this->relatedEvent = $relatedEvent;
        
        return $this;
    }
}
