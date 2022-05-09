<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serialize\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Article
 *
 * @ORM\Table(name="article", indexes={@ORM\Index(name="authorID", columns={"authorID"})})
 * @ORM\Entity

 */
class Article
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     
     *  @return AnnotationException
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="title", type="string", length=50, nullable=false)
     
    
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(name="url", type="text", length=0, nullable=false)
     
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=255, nullable=false)
  
     */
    private $content;

    /**
     * @var \Podcasters
     *
     * @ORM\ManyToOne(targetEntity="Podcasters")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="authorID", referencedColumnName="ID")
  
     * })
     */
    private $authorid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getAuthorid(): ?Podcasters
    {
        return $this->authorid;
    }

    public function setAuthorid(?Podcasters $authorid): self
    {
        $this->authorid = $authorid;

        return $this;
    }


}
