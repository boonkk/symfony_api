<?php

namespace App\Entity;

use App\Repository\AppRoleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppRoleRepository::class)]
#[ORM\UniqueConstraint(
    name: 'app_unique_role',
    columns: ['role']
)]
class AppRole
{
    const ROLE_ADMIN = 'admin';
    const ROLE_MODERATOR = 'moderator';
    const ROLE_CLIENT = 'client';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $role = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
