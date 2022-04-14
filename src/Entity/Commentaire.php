<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CommentaireRepository::class)
 */
class Commentaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

 

   
    /**
     *@Assert\NotBlank(message="remplir le champs content")
     * @ORM\Column(type="string", length=150)
     */
    private $message;



    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="commentaires")
     */
    private $userID;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="commentaires")
     */
    private $articleID;

    /**
     * @ORM\Column(type="datetime")
     */
    private $submitDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

   

    public function getUserID(): ?User
    {
        return $this->userID;
    }

    public function setUserID(?User $userID): self
    {
        $this->userID = $userID;

        return $this;
    }

    public function getArticleID(): ?Article
    {
        return $this->articleID;
    }

    public function setArticleID(?Article $articleID): self
    {
        $this->articleID = $articleID;

        return $this;
    }

    public function getSubmitDate(): ?\DateTimeInterface
    {
        return $this->submitDate;
    }

    public function setSubmitDate(\DateTimeInterface $submitDate): self
    {
        $this->submitDate = $submitDate;

        return $this;
    }
}
