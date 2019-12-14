<?php

namespace App\tempEntity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\TUser;

/**
 * TempEvent
 *
 * 
 */
class TempEvent
{

    /**
     * @var string
     *
     */
    private $name;

    /**
     * @var string
     *
     */
    private $type;

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
    private $totPlace;

    /**
     * @var string
     *
     */
    private $description;

    /**
     * @var \DateTime
     *
     */
    private $startTime;

    /**
     * @var \DateTime
     *
     */
    private $endTime;

    /**
     * @var TDay
     *
     */
    private $fkday;

    /**
     * @var TEvent
     *
     */
    private $fklinkedevent;

    /**
     * @var TUser
     *
     */
    private $creator;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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

    public function getTotPlace(): ?int
    {
        return $this->totPlace;
    }

    public function setTotPlace(int $totPlace): self
    {
        $this->totPlace = $totPlace;

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

    public function getEvebegintime(): ?\DateTime
    {
        return $this->startTime;
    }

    public function setEvebegintime(\DateTime $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getEveendtime(): ?\DateTime
    {
        return $this->endTime;
    }

    public function setEveendtime(\DateTime $endTime): self
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
