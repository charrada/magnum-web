<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert; 

/**
 * Users
 *
 * @ORM\Table(name="Users")
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 * @UniqueEntity("email", "username")
 */
class Users
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

    private $passwordConfirm;

    public function getId(): ?int { return $this->id; }

    public function getUsername(): ?string { return $this->username; }

    public function getEmail(): ?string { return $this->email; }

    public function getPassword(): ?string { return $this->password; }

    public function getPasswordConfirm(): ?string { return $this->passwordConfirm; }

    public function getAvatar(): ?string { return $this->avatar; }

    public function getStatus(): ?string { return $this->status; }

    public function setId(int $id): self {
       $this->id = $id;
       return $this;
    }

    public function setUsername(string $username): self {
       $this->username = $username;
       return $this;
    }

    public function setEmail(string $email): self {
       $this->email = $email;
       return $this;
    }

    public function setPassword(string $password): self {
       $this->password = $password;
       return $this;
    }

    public function setPasswordConfirm(string $passwordConfirm): self {
       $this->passwordConfirm = $passwordConfirm;
       return $this;
    }

    public function setAvatar(string $avatar): self {
       $this->avatar = $avatar;
       return $this;
    }

    public function setStatus(string $status): self {
       $this->status = $status;
       return $this;
    }
}
