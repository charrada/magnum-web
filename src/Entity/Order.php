<?php

namespace App\Entity;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * Order
 *
 * @ORM\Table(name="`order`", indexes={@ORM\Index(name="fk_order_user", columns={"user_id"}), @ORM\Index(name="fk_offer_order", columns={"offer_id"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 */
class Order
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("post:read")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="plan", type="integer", nullable=false)
     * @Groups("post:read")
     */
    private $plan;

    /**
     * @var float
     *
     * @ORM\Column(name="total", type="float", precision=10, scale=0, nullable=false)
     * @Groups("post:read")
     */
    private $total;

    /**
     * @var string
     *
     * @ORM\Column(name="orderdate", type="string", length=30, nullable=false)
     * @Groups("post:read")
     */
    private $orderdate;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=0, nullable=false)
     * @Groups("post:read")
     */
    private $status;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="ID")
     * })
     */
    private $user;

    /**
     * @var \Offer
     *
     * @ORM\ManyToOne(targetEntity="Offer")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="offer_id", referencedColumnName="id")
     * })
     */
    private $offer;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getPlan()
    {
        return $this->plan;
    }

    public function setPlan($plan): self
    {
        $this->plan = $plan;

        return $this;
    }


    public function getTotal()
    {
        return $this->total;
    }


    public function setTotal($total): self
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


    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getOffer(): ?Offer
    {
        return $this->offer;
    }

    public function setOffer(?Offer $offer): self
    {
        $this->offer = $offer;

        return $this;
    }


}
