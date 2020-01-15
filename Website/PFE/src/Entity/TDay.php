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
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @Assert\Length(
     *      min = 2,
     *      max = 45,
     *      minMessage = "Le nom de la journée doit avoir au minimum 2 caractères",
     *      maxMessage = "Le nom de la journée peut avoir au maximum 45 caractères"
     * )
     */
    private $dayname;

    /**
     * @var string
     * 
     * @ORM\Column(name="dayDescription", type="string", length=255, nullable=true)
     * @Assert\Type(
     *     type="string",
     *     message="Le champ est de type texte"
     * )
     *  @Assert\Length(
     *      max = 255,
     *      maxMessage = "La description peut avoir au maximum 255 caractères"
     * )
     */
    private $daydescription;

    /**
     * @Assert\NotBlank
     * @var \DateTime
     * 
     * @ORM\Column(name="dayDate", type="date", length=45, nullable=false)
     */
    private $daydate;

    /**
     * @Assert\NotBlank
     * @var \DateTime
     *
     * @ORM\Column(name="dayBeginTime", type="time", length=45, nullable=false)
     */
    private $daybegintime;

    /**
     * @Assert\NotBlank
     * @var \DateTime 
     *
     * @ORM\Column(name="dayEndTime", type="time", length=45, nullable=false)
     */
    private $dayendtime;

    /**
     *
     * @var bool
     * 
     * @ORM\Column(name="dayRepeat", type="boolean", nullable=true)
     */
    private $dayrepeat=true;

    /**
     * 
     * @var bool
     * 
     * @ORM\Column(name="dayDeleted", type="boolean", nullable=false)
     */
    private $daydeleted=false;

    public function getDaydeleted(): ?bool
    {
        return $this->daydeleted;
    }

    public function setDaydeleted(bool $daydeleted): self
    {
        $this->daydeleted = $daydeleted;

        return $this;
    }

    public function getDayrepeat(): ?bool
    {
        return $this->dayrepeat;
    }

    public function setDayrepeat(bool $dayrepeat): self
    {
        $this->dayrepeat = $dayrepeat;

        return $this;
    }


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

    public function getDaydescription(): ?string
    {
        return $this->daydescription;
    }

    public function setDaydescription(string $daydescription): self
    {
        $this->daydescription = $daydescription;

        return $this;
    }

}
