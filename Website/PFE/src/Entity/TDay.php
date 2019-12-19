<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * TDay
 *
 * @ORM\Table(name="t_day", uniqueConstraints={@ORM\UniqueConstraint(name="idDay_UNIQUE", columns={"idDay"})})
 * @ORM\Entity(repositoryClass="App\Repository\DayRepository")
 */
class TDay
{
    /**
     * @var int
     *
     * @ORM\Column(name="idDay", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idday;

    /**
     * @var string
     * 
     * @ORM\Column(name="dayName", type="string", length=45, nullable=false)
     */
    private $dayname;

    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="dayDate", type="date", length=45, nullable=false)
     */
    private $daydate;

    /**
     * 
     * @var \DateTime
     *
     * @ORM\Column(name="dayBeginTime", type="time", length=45, nullable=false)
     */
    private $daybegintime;

    /**
     * 
     * @var \DateTime 
     *
     * @ORM\Column(name="dayEndTime", type="time", length=45, nullable=false)
     */
    private $dayendtime;

    public function getIdday(): ?int
    {
        return $this->idday;
    }

    public function getDayname(): ?string
    {
        return $this->dayname;
    }

    public function setDayname(string $dayname): self
    {
        $this->dayname = $dayname;

        return $this;
    }

    public function getDaydate(): ?\DateTime
    {
        return $this->daydate;
    }

    public function setDaydate(\DateTime $daydate): self
    {
        $this->daydate = $daydate;

        return $this;
    }

    public function getDaybegintime(): ?\DateTime
    {
        return $this->daybegintime;
    }

    public function setDaybegintime(\DateTime $daybegintime): self
    {
        $this->daybegintime = $daybegintime;

        return $this;
    }

    public function getDayendtime(): ?\DateTime
    {
        return $this->dayendtime;
    }

    public function setDayendtime(\DateTime $dayendtime): self
    {
        $this->dayendtime = $dayendtime;

        return $this;
    }


}
