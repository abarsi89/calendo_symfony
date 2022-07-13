<?php

namespace App\Entity;

use App\Repository\VendorAddressRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VendorAddressRepository::class)
 */
class VendorAddress
{
    /**
     * @ORM\Id
     * @ORM\Column(type="guid")
     */
    private $vendorAddressId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $postalcode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isPrimary;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isBilling;

    /**
     * @ORM\ManyToOne(targetEntity=Vendor::class, inversedBy="vendorAddresses")
     * @ORM\JoinColumn(name="vendor_id", referencedColumnName="vendor_id", nullable=false)
     */
    private $vendor;

    public function getVendorAddressId(): ?string
    {
        return $this->vendorAddressId;
    }

    public function setVendorAddressId(string $vendorAddressId): ?self
    {
        $this->vendorAddressId = $vendorAddressId;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getPostalcode(): ?string
    {
        return $this->postalcode;
    }

    public function setPostalcode(string $postalcode): self
    {
        $this->postalcode = $postalcode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function isPrimary(): ?bool
    {
        return $this->isPrimary;
    }

    public function setPrimary(?bool $isPrimary): self
    {
        $this->isPrimary = $isPrimary;

        return $this;
    }

    public function isBilling(): ?bool
    {
        return $this->isBilling;
    }

    public function setBilling(?bool $isBilling): self
    {
        $this->isBilling = $isBilling;

        return $this;
    }

    public function getVendor(): ?Vendor
    {
        return $this->vendor;
    }

    public function setVendor(?Vendor $vendor): self
    {
        $this->vendor = $vendor;

        return $this;
    }
}
