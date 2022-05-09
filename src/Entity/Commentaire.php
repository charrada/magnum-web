<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire", indexes={@ORM\Index(name="articleID", columns={"articleID"}), @ORM\Index(name="userID", columns={"userID"})})
 * @ORM\Entity
 */
class Commentaire
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=255, nullable=false)
     */
    private $message;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="submitDate", type="date", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $submitdate = 'CURRENT_TIMESTAMP';

    /**
     * @var \Article
     *
     * @ORM\ManyToOne(targetEntity="Article")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="articleid", referencedColumnName="id")
     * })
     */
    private $articleid;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="userid", referencedColumnName="ID")
     * })
     */
    private $userid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getSubmitdate(): ?\DateTimeInterface
    {
        return $this->submitdate;
    }

    public function setSubmitdate(\DateTimeInterface $submitdate): self
    {
        $this->submitdate = $submitdate;

        return $this;
    }

    public function getArticleid(): ?Article
    {
        return $this->articleid;
    }

    public function setArticleid(?Article $articleid): self
    {
        $this->articleid = $articleid;

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
