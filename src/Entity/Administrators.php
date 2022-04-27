<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Administrators
 *
 * @ORM\Table(name="administrators")
 * @ORM\Entity
 */
class Administrators
{
    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=40, nullable=false)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=40, nullable=false)
     */
    private $lastname;

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
