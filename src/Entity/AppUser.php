<?php

namespace App\Entity;

use App\Repository\AppUserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppUserRepository::class)]
#[ORM\UniqueConstraint(
    name: 'app_unique_email',
    columns: ['email']
)]
#[ORM\UniqueConstraint(
    name: 'app_unique_username',
    columns: ['username']
)]
class AppUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function __toString(): string
    {
        return $this->id;
    }


}
