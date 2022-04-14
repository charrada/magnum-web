<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;



/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

  

    /**
      *@Assert\NotBlank(message="remplir le champs url")

     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
          
     *@Assert\NotBlank(message="remplir le champs content")
     * @ORM\Column(type="string", length=255)
     */
    private $content;
/**
        *@Assert\NotBlank(message="remplir le champs titre")

     * @ORM\Column(type="string", length=255)
     */
    private $titre;
    /**
     * @var int
     *
     * @ORM\Column(name="author_id_id", type="integer", nullable=false)
     */
    private $authorID;
   /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="articleID")
     */
    private $commentaires;
   
    /**
     * Article constructor.
     */
    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
    }
 /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setIdreco($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getIdreco() === $this) {
                $comment->setIdreco(null);
            }
        }

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

   

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;

    }

    public function getAuthorID()
    {
        return $this->authorID;
    }

    public function setAuthorID(int $authorID): void
    {
        $this->authorID = $authorID;

    }

    
}
