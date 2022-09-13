<?php

namespace App\Entity;

use App\Repository\AppPermissionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppPermissionRepository::class)]
#[ORM\UniqueConstraint(
    name: 'app_permission_unique_idx',
    columns: ['user', 'application', 'role']
)]
class AppPermission
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?AppUser $user = null;

    #[ORM\Column]
    private ?Application $application = null;

    #[ORM\Column]
    private ?AppRole $role = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?AppUser
    {
        return $this->user;
    }

    public function setUser(AppUser $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getApplication(): ?Application
    {
        return $this->application;
    }

    public function setApplication(Application $application): self
    {
        $this->application = $application;

        return $this;
    }

    public function getRole(): ?AppRole
    {
        return $this->role;
    }

    public function setRole(AppRole $role): self
    {
        $this->role = $role;

        return $this;
    }
}
