<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var string
     *
     * @ORM\Column(name="dayDate", type="string", length=45, nullable=false)
     */
    private $daydate;

    /**
     * @var string
     *
     * @ORM\Column(name="dayBeginTime", type="string", length=45, nullable=false)
     */
    private $daybegintime;

    /**
     * @var string
     *
     * @ORM\Column(name="dayEndTime", type="string", length=45, nullable=false)
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

    public function getDaydate(): ?string
    {
        return $this->daydate;
    }

    public function setDaydate(string $daydate): self
    {
        $this->daydate = $daydate;

        return $this;
    }

    public function getDaybegintime(): ?string
    {
        return $this->daybegintime;
    }

    public function setDaybegintime(string $daybegintime): self
    {
        $this->daybegintime = $daybegintime;

        return $this;
    }

    public function getDayendtime(): ?string
    {
        return $this->dayendtime;
    }

    public function setDayendtime(string $dayendtime): self
    {
        $this->dayendtime = $dayendtime;

        return $this;
    }


}
