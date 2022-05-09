<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Users;
use \DateTime;


/**
 * History
 *
 * @ORM\Table(name="History", indexes={@ORM\Index(name="fk_userID_hist", columns={"userID"})})
 * @ORM\Entity(repositoryClass="App\Repository\HistoryRepository")
 */
class History
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="activity", type="string", length=30, nullable=true)
     */
    private $activity;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=200, nullable=false)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $time = "CURRENT_TIMESTAMP";

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="userID", referencedColumnName="ID")
     * })
     */

    private $user;

    public function getID(): ?int
    {
        return $this->id;
    }

    public function setID(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getActivity(): ?string
    {
        return $this->activity;
    }

    public function setActivity(string $activity): self
    {
        $this->activity = $activity;
        return $this;
    }

    public function getTime(): DateTime

    {
        return $this->time;
    }

    public function setTime(DateTime $time): self
    {
        $this->time = $time;
        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }
    
    public function setUser(Users $user): self
    {
        $this->user = $user;
        return $this;
    }
}
