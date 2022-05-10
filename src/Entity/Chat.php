<?php

namespace App\Entity;

use App\Repository\ChatRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ChatRepository::class)
 */
class Chat
{
  
    /**
     * @ORM\Column(type="integer")
     * @Groups("post:read")
     */
    private $id;

    /**
     * @Groups("post:read")
     * @ORM\Column(type="string", length=255)
     */
    private $resolverid;

    /**
     * @Groups("post:read")
     * @ORM\Column(type="string", length=255)
     */
    private $msg;

    /**
     * @ORM\Id
     * @Groups("post:read")
     * @ORM\Column(type="string", length=255)
     */
    private $datem;

    /**
     * @Groups("post:read")
     * @ORM\Column(type="integer")
     */
    private $userid;

    /**
     * @Groups("post:read")
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $ifrom;

    public function getid(): ?int
    {
        return $this->id;
    }

    public function setid(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getresolverid(): ?string
    {
        return $this->resolverid;
    }

    public function setReSolverID(string $resolverid): self
    {
        $this->resolverid = $resolverid;

        return $this;
    }

    public function getmsg(): ?string
    {
        return $this->msg;
    }

    public function setmsg(string $msg): self
    {
        $this->msg = $msg;

        return $this;
    }

    public function getdatem(): ?string
    {
        return $this->datem;
    }

    public function setdatem(string $datem): self
    {
        $this->datem = $datem;

        return $this;
    }

    public function getuserid(): ?int
    {
        return $this->userid;
    }

    public function setuserid(int $userid): self
    {
        $this->userid = $userid;

        return $this;
    }

    public function getifrom(): ?string
    {
        return $this->ifrom;
    }

    public function setifrom(string $ifrom): self
    {
        $this->ifrom = $ifrom;

        return $this;
    }
}
