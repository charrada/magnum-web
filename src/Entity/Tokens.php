<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tokens
 *
 * @ORM\Table(name="tokens", indexes={@ORM\Index(name="fk_userID_tokens", columns={"userID"})})
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
    private $consumed = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false, options={"default"="current_timestamp()"})
     */
    private $created = 'current_timestamp()';

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="userID", referencedColumnName="ID")
     * })
     */
    private $userid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getConsumed(): ?bool
    {
        return $this->consumed;
    }

    public function setConsumed(bool $consumed): self
    {
        $this->consumed = $consumed;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getUserid(): ?Users
    {
        return $this->userid;
    }

    public function setUserid(?Users $userid): self
    {
        $this->userid = $userid;

        return $this;
    }


}
