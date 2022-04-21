<?php

namespace App\Entity;

use App\Repository\ChatRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChatRepository::class)
 */
class Chat
{
  
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $ID;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $resolverid;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $msg;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $datem;

    /**
     * @ORM\Column(type="integer")
     */
    private $userid;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ifrom;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setID(int $ID): self
    {
        $this->ID = $ID;

        return $this;
    }

    public function getReSolverID(): ?string
    {
        return $this->ReSolverID;
    }

    public function setReSolverID(string $ReSolverID): self
    {
        $this->ReSolverID = $ReSolverID;

        return $this;
    }

    public function getMsg(): ?string
    {
        return $this->Msg;
    }

    public function setMsg(string $Msg): self
    {
        $this->Msg = $Msg;

        return $this;
    }

    public function getDateM(): ?string
    {
        return $this->DateM;
    }

    public function setDateM(string $DateM): self
    {
        $this->DateM = $DateM;

        return $this;
    }

    public function getUSERID(): ?int
    {
        return $this->USERID;
    }

    public function setUSERID(int $USERID): self
    {
        $this->USERID = $USERID;

        return $this;
    }

    public function getIfrom(): ?string
    {
        return $this->Ifrom;
    }

    public function setIfrom(string $Ifrom): self
    {
        $this->Ifrom = $Ifrom;

        return $this;
    }
}
