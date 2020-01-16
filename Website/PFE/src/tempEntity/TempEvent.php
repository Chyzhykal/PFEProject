<?php

namespace App\tempEntity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\TUser;
use App\Entity\TEventPriority;

/**
 * TempEvent
 *
 * 
 */
class TempEvent
{

    /**
     * @var TEventPriority
     *
     */
    private $priority;

    /**
     * @var string
     *
     */
    private $name;

    /**
     * @var string
     *
     */
    private $author;

    /**
     * @var string
     *
     */
    private $class;

    /**
     * @var int
     *
     */
    private $totalPlaces;

    /**
     * @var string
     *
     */
    private $description;

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

    /**
     * @var bool
     *
     */
    private $eventRelated;

    public function getEventRelated(): ?bool
    {
        return $this->eventRelated;
    }

    public function setEventRelated(bool $eventRelated): self
    {
        $this->eventRelated = $eventRelated;
        
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        
        return $this;
    }

    public function getPriority(): ?TEventPriority
    {
        return $this->priority;
    }

    public function setPriority(TEventPriority $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getClass(): ?string
    {
        return $this->class;
    }

    public function setClass(string $class): self
    {
        $this->class = $class;

        return $this;
    }

    public function getTotalPlaces(): ?int
    {
        return $this->totalPlaces;
    }

    public function setTotalPlaces(int $totalPlaces): self
    {
        $this->totalPlaces = $totalPlaces;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

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

    public function getFkday(): ?TDay
    {
        return $this->fkday;
    }

    public function setFkday(?TDay $fkday): self
    {
        $this->fkday = $fkday;

        return $this;
    }

    public function getFklinkedevent(): ?TEvent
    {
        return $this->fklinkedevent;
    }

    public function setFklinkedevent(?self $fklinkedevent): self
    {
        $this->fklinkedevent = $fklinkedevent;

        return $this;
    }

    public function getCreator(): ?TUser
    {
        return $this->creator;
    }

    public function setCreator(?TUser $creator): self
    {
        $this->creator = $creator;

        return $this;
    }
}
