<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity
 */
class Categorie
{
    /**
     * @var int
     *
     * @ORM\Column(name="idcategorie", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("post:read")
     */
    private $idcategorie;

    /**
     * @var string
     *
     * @ORM\Column(name="namecateg", type="string", length=255, nullable=false)
     * @Groups("post:read")
     */
    private $namecateg;

    /**
     * @var string
     *
     * @ORM\Column(name="descriptioncateg", type="string", length=255, nullable=false)
     * @Groups("post:read")
     */
    private $descriptioncateg;

    public function getIdcategorie(): ?int
    {
        return $this->idcategorie;
    }

    public function getNamecateg(): ?string
    {
        return $this->namecateg;
    }

    public function setNamecateg(string $namecateg): self
    {
        $this->namecateg = $namecateg;

        return $this;
    }

    public function getDescriptioncateg(): ?string
    {
        return $this->descriptioncateg;
    }

    public function setDescriptioncateg(string $descriptioncateg): self
    {
        $this->descriptioncateg = $descriptioncateg;

        return $this;
    }


}
