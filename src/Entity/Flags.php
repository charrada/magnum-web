<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Flags
 *
 * @ORM\Table(name="Flags", indexes={@ORM\Index(name="fk_flaggerID_flags", columns={"flaggerID"}), @ORM\Index(name="fk_userID_flags", columns={"flaggedID"})})
 * @ORM\Entity
 */
class Flags
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
     * @ORM\Column(name="offense", type="string", length=30, nullable=true)
     */
    private $offense;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=400, nullable=false)
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
     *   @ORM\JoinColumn(name="flaggedID", referencedColumnName="ID")
     * })
     */
    private $flaggedid;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="flaggerID", referencedColumnName="ID")
     * })
     */
    private $flaggerid;
}
