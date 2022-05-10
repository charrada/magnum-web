<?php

namespace App\Entity;

use App\Repository\TickettypeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
/**
 * @ORM\Entity(repositoryClass=TickettypeRepository::class)
 */
class Tickettype
{

    /**
     * @ORM\Id
     * @Groups("post:read")
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $itype;

    /**
     * @Groups("post:read")
     * @ORM\Column(type="string", length=255,nullable=false)
     */
    private $type;

    public function getid(): ?int
    {
        return $this->id;
    }

    public function getitype(): ?int
    {
        return $this->itype;
    }

    public function setitype(int $itype): self
    {
        $this->itype = $itype;

        return $this;
    }

    public function gettype(): ?string
    {
        return $this->type;
    }

    public function settype(string $type): self
    {
        $this->type = $type;

        return $this;
    }
    public function __toString()
    {
        return $this->gettype();
    }
}
