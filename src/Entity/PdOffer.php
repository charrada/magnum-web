<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PdOffer
 *
 * @ORM\Table(name="pd_offer")
 * @ORM\Entity
 */
class PdOffer
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
     * @var int
     *
     * @ORM\Column(name="podcast_id", type="integer", nullable=false)
     */
    private $podcastId;

    /**
     * @var int
     *
     * @ORM\Column(name="offer_id", type="integer", nullable=false)
     */
    private $offerId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPodcastId(): ?int
    {
        return $this->podcastId;
    }

    public function setPodcastId(int $podcastId): self
    {
        $this->podcastId = $podcastId;

        return $this;
    }

    public function getOfferId(): ?int
    {
        return $this->offerId;
    }

    public function setOfferId(int $offerId): self
    {
        $this->offerId = $offerId;

        return $this;
    }


}
