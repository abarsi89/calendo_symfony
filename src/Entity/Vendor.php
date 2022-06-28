<?php

namespace App\Entity;

use App\Repository\VendorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VendorRepository::class)
 */
class Vendor
{
    /**
     * @ORM\Id
     * @ORM\Column(type="guid")
     */
    private $vendorId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $primaryCountry;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $primaryPostalcode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $primaryCity;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $primaryAddress;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $billingCountry;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $billingPostalcode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $billingCity;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $billingAddress;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $vatNumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bankAccountNumber;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $deletedAt;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="vendor")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getVendorId(): ?string
    {
        return $this->vendorId;
    }

    /**
     * Symfony-s faszság miatt kell ez a metódus...
     * @return string|null
     */
    public function getvendor_id(): ?string
    {
        return $this->vendorId;
    }

    public function setVendorId(string $vendorId): self
    {
        $this->vendorId = $vendorId;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

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

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getPrimaryCountry(): ?string
    {
        return $this->primaryCountry;
    }

    public function setPrimaryCountry(string $primaryCountry): self
    {
        $this->primaryCountry = $primaryCountry;

        return $this;
    }

    public function getPrimaryPostalcode(): ?string
    {
        return $this->primaryPostalcode;
    }

    public function setPrimaryPostalcode(string $primaryPostalcode): self
    {
        $this->primaryPostalcode = $primaryPostalcode;

        return $this;
    }

    public function getPrimaryCity(): ?string
    {
        return $this->primaryCity;
    }

    public function setPrimaryCity(string $primaryCity): self
    {
        $this->primaryCity = $primaryCity;

        return $this;
    }

    public function getPrimaryAddress(): ?string
    {
        return $this->primaryAddress;
    }

    public function setPrimaryAddress(string $primaryAddress): self
    {
        $this->primaryAddress = $primaryAddress;

        return $this;
    }

    public function getBillingCountry(): ?string
    {
        return $this->billingCountry;
    }

    public function setBillingCountry(string $billingCountry): self
    {
        $this->billingCountry = $billingCountry;

        return $this;
    }

    public function getBillingPostalcode(): ?string
    {
        return $this->billingPostalcode;
    }

    public function setBillingPostalcode(string $billingPostalcode): self
    {
        $this->billingPostalcode = $billingPostalcode;

        return $this;
    }

    public function getBillingCity(): ?string
    {
        return $this->billingCity;
    }

    public function setBillingCity(string $billingCity): self
    {
        $this->billingCity = $billingCity;

        return $this;
    }

    public function getBillingAddress(): ?string
    {
        return $this->billingAddress;
    }

    public function setBillingAddress(string $billingAddress): self
    {
        $this->billingAddress = $billingAddress;

        return $this;
    }

    public function getVatNumber(): ?string
    {
        return $this->vatNumber;
    }

    public function setVatNumber(string $vatNumber): self
    {
        $this->vatNumber = $vatNumber;

        return $this;
    }

    public function getBankAccountNumber(): ?string
    {
        return $this->bankAccountNumber;
    }

    public function setBankAccountNumber(string $bankAccountNumber): self
    {
        $this->bankAccountNumber = $bankAccountNumber;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeImmutable $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

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
            $user->setVendor($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getVendor() === $this) {
                $user->setVendor(null);
            }
        }

        return $this;
    }
}
