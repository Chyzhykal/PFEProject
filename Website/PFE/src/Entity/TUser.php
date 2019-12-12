<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * TUser
 *
 * @ORM\Table(name="t_user", uniqueConstraints={@ORM\UniqueConstraint(name="idUser_UNIQUE", columns={"idUser"})})
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */ 
class TUser
{

    /**
     * @var int
     *
     * @ORM\Column(name="idUser", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $iduser;

    /**
     * @var string
     *
     * @ORM\Column(name="useLogin", type="string", length=100, nullable=false)
     * @Assert\NotBlank
     * @Assert\Type("string")
     */
    private $uselogin;

    /**
     * @var string
     *
     * @ORM\Column(name="usePwd", type="string", length=255, nullable=false)
     * @Assert\NotBlank
     * @Assert\Type("string")
     */
    private $usepwd;

    /**
     * @var string
     *
     * @ORM\Column(name="useRight", type="string", length=45, nullable=false, options={"default"="Standard"})
     */
    private $useright = 'Standard';

    /**
     * @var string|null
     *
     * @ORM\Column(name="useFirstName", type="string", length=45, nullable=true)
     */
    private $usefirstname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="useLastName", type="string", length=45, nullable=true)
     */
    private $uselastname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="useRole", type="string", length=45, nullable=true)
     */
    private $userole;

    public function getIduser(): ?int
    {
        return $this->iduser;
    }

    public function getUselogin(): ?string
    {
        return $this->uselogin;
    }

    public function setUselogin(string $uselogin): self
    {
        $this->uselogin = $uselogin;

        return $this;
    }

    public function getUsepwd(): ?string
    {
        return $this->usepwd;
    }

    public function setUsepwd(string $usepwd): self
    {
        $this->usepwd = $usepwd;

        return $this;
    }

    public function getUseright(): ?string
    {
        return $this->useright;
    }

    public function setUseright(string $useright): self
    {
        $this->useright = $useright;

        return $this;
    }

    public function getUsefirstname(): ?string
    {
        return $this->usefirstname;
    }

    public function setUsefirstname(?string $usefirstname): self
    {
        $this->usefirstname = $usefirstname;

        return $this;
    }

    public function getUselastname(): ?string
    {
        return $this->uselastname;
    }

    public function setUselastname(?string $uselastname): self
    {
        $this->uselastname = $uselastname;

        return $this;
    }

    public function getUserole(): ?string
    {
        return $this->userole;
    }

    public function setUserole(?string $userole): self
    {
        $this->userole = $userole;

        return $this;
    }

   
}
