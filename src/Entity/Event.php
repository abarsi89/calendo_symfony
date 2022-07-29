<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\Column(type="guid")
     */
    private $eventId;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Service::class, inversedBy="events")
     * @ORM\JoinColumn(name="service_id", referencedColumnName="service_id", nullable=false)
     */
    private $service;

    /**
     * @ORM\ManyToOne(targetEntity=VendorAddress::class, inversedBy="events")
     * @ORM\JoinColumn(name="vendor_address_id", referencedColumnName="vendor_address_id", nullable=false)
     */
    private $address;

    private $vendorId;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="events")
     * @ORM\JoinTable(name="users_events",
     *     joinColumns={@ORM\JoinColumn(name="event_id", referencedColumnName="event_id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="user_id")}
     *     )
     */
    private $users;

    private $customerEmail;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getVendorId(): ?string
    {
        return $this->vendorId;
    }

    public function setVendorId(string $vendorId): self
    {
        $this->vendorId = $vendorId;

        return $this;
    }

    public function getEventId(): ?string
    {
        return $this->eventId;
    }

    public function setEventId(string $eventId): self
    {
        $this->eventId = $eventId;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getAddress(): ?VendorAddress
    {
        return $this->address;
    }

    public function setAddress(?VendorAddress $address): self
    {
        $this->address = $address;

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

    public function getCustomerEmail(): ?string
    {
        return $this->customerEmail;
    }

    public function setCustomerEmail(?string $customerEmail): self
    {
        $this->customerEmail = $customerEmail;

        return $this;
    }
}
