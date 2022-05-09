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
class Administrators extends Users implements \Serializable
{
    /**
     * @var \Users
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID", referencedColumnName="ID")
     * })
     */
    private $id;

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


    public function getRoles()
    {
        return array('ROLE_ADMINS');
    }

    public function getId(): ?int
    {
        return parent::getID();
    }

    public function setId(int $id): self
    {
        $this->id = id;
        return $this;
    }

    public function getLastName(): ?string

    {
        return $this->lastname;
    }


    public function setLastName(string $lastname): self {
        $this->lastname = lastname;
        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstname;
    }

    public function setFirstName(string $firstname): self
    {
        $this->firstname = firstname;
        return $this;
    }
}
