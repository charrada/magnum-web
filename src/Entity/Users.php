<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Users
 *
 * @ORM\Table(name="Users")
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 * @InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({
 *      "users" = "App\Entity\Users",
 *      "administrators" = "App\Entity\Administrators",
 *      "podcasters" = "App\Entity\Podcasters"
 * })
 * @UniqueEntity("email", "username")
 */
class Users implements UserInterface, \Serializable

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
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=40, unique=true, nullable=false)
     */
    private $username;

    /**
     * @var string
     *

     * @ORM\Column(name="email", type="string", length=80, unique=true, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=72, nullable=false)
     */
    private $password;

    /**
     * @var string|null
     *
     * @ORM\Column(name="avatar", type="string", length=120, nullable=true, options={"comment"="The name and extension of the image file that represents the avatar of the user, e.g. ""grtcdr.png"""})
     */
    private $avatar;

    /**
     * @var string|null
     *
     * @ORM\Column(name="status", type="string", length=30, nullable=true)
     */
    private $status;

    /* Used in security details form */
    private $newPassword;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getNewPassword(): ?string
    {
        return $this->newPassword;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function setPassword(string $pw): self
    {
        $this->password = $pw;
        return $this;
    }

    public function setNewPassword(string $pw): self
    {
        $this->newPassword = $pw;
        return $this;
    }

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;
        return $this;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getRoles()
    {
        return array('ROLE_USERS');
    }

    public function eraseCredentials() {}

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->avatar,
            $this->status,
            $this->username,
            $this->password
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->email,
            $this->avatar,
            $this->status,
            $this->username,
            $this->password
        ) = unserialize($serialized, array('allowed_classes' => false));
    }
}
