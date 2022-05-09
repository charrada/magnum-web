<?php

namespace App\Entity;

use \DateTime;
use App\Entity\Users;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tokens
 *
 * @ORM\Table(name="Tokens", indexes={@ORM\Index(name="fk_userID_tokens", columns={"userID"})})
 * @ORM\Entity
 */
class Tokens
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=128, nullable=false)
     */
    private $token;

    /**
     * @var bool
     *
     * @ORM\Column(name="consumed", type="boolean", nullable=false)
     */
    private $consumed = "0";


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $created = "CURRENT_TIMESTAMP";

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="userID", referencedColumnName="ID")
     * })
     */
    private $user;

    private $username;

    public function getID(): ?int
    {
        return $this->id;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }
    public function getCreated()
    {
        return $this->created;
    }
    public function isConsumed(): ?bool
    {
        return $this->consumed;
    }
    public function getUser(): ?int
    {
        return $this->userid;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setUser(Users $user): self
    {
        $this->user = $user;
        return $this;
    }


    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function setCreated(DateTime $created): self
    {
        $this->created = $created;
        return $this;

    }

    public function setConsumed(bool $consumed): self
    {
        $this->consumed = $consumed;

        return $this;
    }
}
