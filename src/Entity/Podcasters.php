<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Users;

/**
 * Podcasters
 *
 * @ORM\Table(name="Podcasters")
 * @ORM\Entity
 */
class Podcasters extends Users
{
    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=40, nullable=false, options={"comment"="This attribute can be used as the name of the podcast and not necessarily that of the account holder."})
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=40, nullable=false, options={"comment"="This attribute can be used as the name of the podcast and not necessarily that of the account holder."})
     */
    private $lastname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="biography", type="string", length=200, nullable=true, options={"comment"="A short and sweet paragraph that tells users a little bit about the podcaster."})
     */
    private $biography;

    /**
     * @var \Users
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID", referencedColumnName="ID")
     * })
     */
    private $id;

    public function getRoles()
    {
        return array('ROLE_PODCASTERS');
    }

    public function getId(): ?int
    {
        return parent::getID();
    }

    public function getLastName(): ?string
    {
        return $this->lastname;
    }

    public function getFirstName(): ?string
    {
        return $this->firstname;
    }

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function setId(int $id): self
    {
        $this->id = id;
        return $this;
    }

    public function setFirstName(string $firstname): self
    {
        $this->firstname = firstname;
        return $this;
    }

    public function setLastName(string $lastname): self
    {
        $this->lastname = lastname;
        return $this;
    }

    public function setBiography(string $biography): self
    {
        $this->biography = biography;
        return $this;
    }

}

