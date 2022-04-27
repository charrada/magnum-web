<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Flags
 *
 * @ORM\Table(name="flags", indexes={@ORM\Index(name="fk_userID_flags", columns={"userID"})})
 * @ORM\Entity
 */
class Flags
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
     * @ORM\Column(name="offense", type="string", length=0, nullable=false)
     */
    private $offense;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=400, nullable=false)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time", type="datetime", nullable=false, options={"default"="current_timestamp()"})
     */
    private $time = 'current_timestamp()';

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

    public function getOffense(): ?string
    {
        return $this->offense;
    }

    public function setOffense(string $offense): self
    {
        $this->offense = $offense;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): self
    {
        $this->time = $time;

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
