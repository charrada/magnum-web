<?php

namespace App\Entity;

use App\Repository\TicketkindRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TicketkindRepository::class)
 */
class Ticketkind
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $itype;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    public function getid(): ?int
    {
        return $this->id;
    }

    public function setid(int $id): self
    {
        $this->id = $id;

        return $this;
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
}
