<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'Il existe déjà un compte avec cet e-mail')]
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
   use CreatedAtTrait;
   
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 100)]
    private ?string $lastname = null;

    #[ORM\Column(length: 100)]
    private ?string $firtsname = null;

    // #[ORM\Column(length: 255)]
    // private ?string $address = null;

    // #[ORM\Column(length: 5)]
    // private ?string $zipcode = null;

    // #[ORM\Column(length: 150)]
    // private ?string $city = null;

    // #[ORM\Column(length: 15, nullable: true)]
    // private ?string $phone = null;

    #[ORM\OneToMany(mappedBy: 'users', targetEntity: Orders::class)]
    private Collection $orders;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Address::class)]
    private Collection $addresses;

    // #[ORM\Column]
    // private ?\DateTimeImmutable $created_at = null;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->created_at= new \DateTimeImmutable();
        $this->addresses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirtsname(): ?string
    {
        return $this->firtsname;
    }

    public function setFirtsname(string $firtsname): self
    {
        $this->firtsname = $firtsname;

        return $this;
    }

    // public function getAddress(): ?string
    // {
    //     return $this->address;
    // }

    // public function setAddress(string $address): self
    // {
    //     $this->address = $address;

    //     return $this;
    // }

    // public function getZipcode(): ?string
    // {
    //     return $this->zipcode;
    // }

    // public function setZipcode(string $zipcode): self
    // {
    //     $this->zipcode = $zipcode;

    //     return $this;
    // }

    // public function getCity(): ?string
    // {
    //     return $this->city;
    // }

    // public function setCity(string $city): self
    // {
    //     $this->city = $city;

    //     return $this;
    // }

    // public function getPhone(): ?string
    // {
    //     return $this->phone;
    // }

    // public function setPhone(?string $phone): self
    // {
    //     $this->phone = $phone;

    //     return $this;
    // }

    /**
     * @return Collection<int, Orders>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Orders $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            // $this->orders[] =$order;
            $order->setUsers($this);
        }

        return $this;
    }

    public function removeOrder(Orders $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getUsers() === $this) {
                $order->setUsers(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->firtsname;
    }

    // public function getCreatedAt(): ?\DateTimeImmutable
    // {
    //     return $this->created_at;
    // }

    // public function setCreatedAt(\DateTimeImmutable $created_at): self
    // {
    //     $this->created_at = $created_at;

    //     return $this;
    // }

    /**
     * @return Collection<int, Address>
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    public function addAddress(Address $address): self
    {
        if (!$this->addresses->contains($address)) {
            $this->addresses->add($address);
            $address->setUser($this);
        }

        return $this;
    }

    public function removeAddress(Address $address): self
    {
        if ($this->addresses->removeElement($address)) {
            // set the owning side to null (unless already changed)
            if ($address->getUser() === $this) {
                $address->setUser(null);
            }
        }

        return $this;
    }


}
