<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Order
 *
 * @ORM\Table(name="order", indexes={@ORM\Index(name="fk_offer_order", columns={"offer_id"})})
 * @ORM\Entity
 */
class Order
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
     * @ORM\Column(name="offer_id", type="integer", nullable=false)
     */
    private $offerId;

    /**
     * @var int
     *
     * @ORM\Column(name="plan", type="integer", nullable=false)
     */
    private $plan;

    /**
     * @var float
     *
     * @ORM\Column(name="total", type="float", precision=10, scale=0, nullable=false)
     */
    private $total;

    /**
     * @var string
     *
     * @ORM\Column(name="orderdate", type="string", length=30, nullable=false)
     */
    private $orderdate;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=0, nullable=false)
     */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPlan(): ?int
    {
        return $this->plan;
    }

    public function setPlan(int $plan): self
    {
        $this->plan = $plan;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getOrderdate(): ?string
    {
        return $this->orderdate;
    }

    public function setOrderdate(string $orderdate): self
    {
        $this->orderdate = $orderdate;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }


}
