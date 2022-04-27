<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Podcasters
 *
 * @ORM\Table(name="podcasters")
 * @ORM\Entity
 */
class Podcasters
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
     * @ORM\Column(name="biography", type="string", length=200, nullable=true, options={"default"="NULL","comment"="A short and sweet paragraph that tells users a little bit about the podcaster."})
     */
    private $biography = 'NULL';

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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function setBiography(?string $biography): self
    {
        $this->biography = $biography;

        return $this;
    }

    public function getId(): ?Users
    {
        return $this->id;
    }

    public function setId(?Users $id): self
    {
        $this->id = $id;

        return $this;
    }


}
