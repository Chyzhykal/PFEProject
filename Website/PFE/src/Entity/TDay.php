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
     * @ORM\
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


}
