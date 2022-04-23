<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Users;

/**
 * Administrators
 *
 * @ORM\Table(name="Administrators")
 * @ORM\Entity
 */
class Administrators extends Users
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastName(): ?string
    {
        return $this->lastname;
    }

    public function getFirstName(): ?string
    {
        return $this->firstname;
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
}
