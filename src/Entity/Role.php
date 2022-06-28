<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RoleRepository::class)
 */
class Role
{
//    const ROLE_USER = 0;
//    const ROLE_CUSTOMER = 1;
//    const ROLE_ADMIN = 2;
//    const ROLE_SUPERADMIN = 3;

    const ROLE_USER = 'USER';
    const ROLE_CUSTOMER = 'CUSTOMER';
    const ROLE_ADMIN = 'ADMIN';
    const ROLE_SUPERADMIN = 'SUPERADMIN';

    /**
     * @ORM\Id
     * @ORM\Column(type="guid")
     */
    private $roleId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="roles")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getRoleId(): ?string
    {
        return $this->roleId;
    }

    public function setRoleId(string $roleId): self
    {
        $this->roleId = $roleId;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->users->removeElement($user);

        return $this;
    }
}
