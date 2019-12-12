<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * TEvent
 *
 * @ORM\Table(name="t_event", uniqueConstraints={@ORM\UniqueConstraint(name="idEvent_UNIQUE", columns={"idEvent"})}, indexes={@ORM\Index(name="fk_t_event_t_user1_idx", columns={"fkUser"}), @ORM\Index(name="fk_t_event_t_event1", columns={"fkLinkedEvent"}), @ORM\Index(name="fk_t_event_t_day1_idx", columns={"fkDay"})})
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class TEvent
{
    /**
     * @var int
     *
     * @ORM\Column(name="idEvent", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idevent;

    /**
     * @var string
     *
     * @ORM\Column(name="eveName", type="string", length=255, nullable=false)
     */
    private $evename;

    /**
     * @var string
     *
     * @ORM\Column(name="eveType", type="string", length=255, nullable=false)
     */
    private $evetype;

    /**
     * @var string
     *
     * @ORM\Column(name="eveAuthor", type="string", length=255, nullable=false)
     */
    private $eveauthor;

    /**
     * @var string
     *
     * @ORM\Column(name="eveClass", type="string", length=255, nullable=false)
     */
    private $eveclass;

    /**
     * @var string
     *
     * @ORM\Column(name="eveTotPlaceNum", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $evetotplacenum;

    /**
     * @var string
     *
     * @ORM\Column(name="evePlaceLeft", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $eveplaceleft;

    /**
     * @var string
     *
     * @ORM\Column(name="eveDescription", type="text", length=65535, nullable=false)
     */
    private $evedescription;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="eveBeginTime", type="time", nullable=false)
     */
    private $evebegintime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="eveEndTime", type="time", nullable=false)
     */
    private $eveendtime;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="TDay")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fkDay", referencedColumnName="idDay")
     * })
     */
    private $fkday;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="TEvent")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fkLinkedEvent", referencedColumnName="idEvent")
     * })
     */
    private $fklinkedevent;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="TUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fkUser", referencedColumnName="idUser")
     * })
     */
    private $fkuser;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="TParticipant", inversedBy="fkevent")
     * @ORM\JoinTable(name="t_event_has_t_participant",
     *   joinColumns={
     *     @ORM\JoinColumn(name="fkEvent", referencedColumnName="idEvent")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="fkParticipant", referencedColumnName="idParticipant")
     *   }
     * )
     */
    private $fkparticipant;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkparticipant = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdevent(): ?int
    {
        return $this->idevent;
    }

    public function getEvename(): ?string
    {
        return $this->evename;
    }

    public function setEvename(string $evename): self
    {
        $this->evename = $evename;

        return $this;
    }

    public function getEvetype(): ?string
    {
        return $this->evetype;
    }

    public function setEvetype(string $evetype): self
    {
        $this->evetype = $evetype;

        return $this;
    }

    public function getEveauthor(): ?string
    {
        return $this->eveauthor;
    }

    public function setEveauthor(string $eveauthor): self
    {
        $this->eveauthor = $eveauthor;

        return $this;
    }

    public function getEveclass(): ?string
    {
        return $this->eveclass;
    }

    public function setEveclass(string $eveclass): self
    {
        $this->eveclass = $eveclass;

        return $this;
    }

    public function getEvetotplacenum(): ?string
    {
        return $this->evetotplacenum;
    }

    public function setEvetotplacenum(string $evetotplacenum): self
    {
        $this->evetotplacenum = $evetotplacenum;

        return $this;
    }

    public function getEveplaceleft(): ?string
    {
        return $this->eveplaceleft;
    }

    public function setEveplaceleft(string $eveplaceleft): self
    {
        $this->eveplaceleft = $eveplaceleft;

        return $this;
    }

    public function getEvedescription(): ?string
    {
        return $this->evedescription;
    }

    public function setEvedescription(string $evedescription): self
    {
        $this->evedescription = $evedescription;

        return $this;
    }

    public function getEvebegintime(): ?\DateTimeInterface
    {
        return $this->evebegintime;
    }

    public function setEvebegintime(\DateTimeInterface $evebegintime): self
    {
        $this->evebegintime = $evebegintime;

        return $this;
    }

    public function getEveendtime(): ?\DateTimeInterface
    {
        return $this->eveendtime;
    }

    public function setEveendtime(\DateTimeInterface $eveendtime): self
    {
        $this->eveendtime = $eveendtime;

        return $this;
    }

    public function getFkday(): ?int
    {
        return $this->fkday;
    }

    public function setFkday(?TDay $fkday): self
    {
        $this->fkday = $fkday;

        return $this;
    }

    public function getFklinkedevent(): ?int
    {
        return $this->fklinkedevent;
    }

    public function setFklinkedevent(?self $fklinkedevent): self
    {
        $this->fklinkedevent = $fklinkedevent;

        return $this;
    }

    public function getFkuser(): ?int
    {
        return $this->fkuser;
    }

    public function setFkuser(?TUser $fkuser): self
    {
        $this->fkuser = $fkuser;

        return $this;
    }

    /**
     * @return Collection|TParticipant[]
     */
    public function getFkparticipant(): Collection
    {
        return $this->fkparticipant;
    }

    public function addFkparticipant(TParticipant $fkparticipant): self
    {
        if (!$this->fkparticipant->contains($fkparticipant)) {
            $this->fkparticipant[] = $fkparticipant;
        }

        return $this;
    }

    public function removeFkparticipant(TParticipant $fkparticipant): self
    {
        if ($this->fkparticipant->contains($fkparticipant)) {
            $this->fkparticipant->removeElement($fkparticipant);
        }

        return $this;
    }

}
