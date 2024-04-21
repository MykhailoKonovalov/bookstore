<?php

namespace App\Entity;

use App\Constant\UserRoles;
use App\Entity\Interfaces\HasTimestamp;
use App\Entity\Interfaces\HasUUID;
use App\Entity\Traits\TimestampTrait;
use App\Entity\Traits\UUIDTrait;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: "users")]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: false)]
#[ORM\UniqueConstraint(name: "UNIQ_IDENTIFIER_EMAIL", fields: ["email"])]
#[ORM\UniqueConstraint(name: "UNIQ_IDENTIFIER_PHONE", fields: ["phone"])]
#[ORM\Index(columns: ["email"], name: "user_email_idx")]
#[ORM\Index(columns: ["phone"], name: "user_phone_idx")]
#[ORM\HasLifecycleCallbacks]
class User implements
    UserInterface,
    PasswordAuthenticatedUserInterface,
    HasUUID,
    HasTimestamp
{
    use UUIDTrait;

    use TimestampTrait;

    use SoftDeleteableEntity;

    #[ORM\Column(type: Types::STRING, length: 180)]
    private string $email;

    /**
     * @var list<string>
     */
    #[ORM\Column(type: Types::JSON)]
    private array $roles;

    #[ORM\Column(type: Types::STRING)]
    private string $password;

    #[ORM\Column(length: 13)]
    private string $phone;

    #[ORM\Column(type: Types::STRING)]
    private string $name;

    /**
     * @var Collection<int, Review>
     */
    #[ORM\OneToMany(mappedBy: 'userUuid', targetEntity: Review::class, orphanRemoval: true)]
    private Collection $reviews;

    /**
     * @var Collection<int, Order>
     */
    #[ORM\OneToMany(mappedBy: 'userUuid', targetEntity: Order::class)]
    private Collection $orders;

    /**
     * @var Collection<int, WishList>
     */
    #[ORM\OneToMany(mappedBy: 'userUuid', targetEntity: WishList::class, orphanRemoval: true)]
    private Collection $wishLists;

    public function __construct()
    {
        $this->roles = [UserRoles::ROLE_USER->value];
        $this->reviews = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->wishLists = new ArrayCollection();
    }

    public function getEmail(): string
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
        return $this->email;
    }

    /**
     * @return list<string>
     * @see UserInterface
     *
     */
    public function getRoles(): array
    {
        return array_unique($this->roles);
    }

    /**
     * @param list<string> $roles
     */
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
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews->add($review);
            $review->setUserUuid($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getUserUuid() === $this) {
                $review->setUserUuid(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setUserUuid($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getUserUuid() === $this) {
                $order->setUserUuid(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, WishList>
     */
    public function getWishLists(): Collection
    {
        return $this->wishLists;
    }

    public function addWishList(WishList $wishList): self
    {
        if (!$this->wishLists->contains($wishList)) {
            $this->wishLists->add($wishList);
            $wishList->setUserUuid($this);
        }

        return $this;
    }

    public function removeWishList(WishList $wishList): self
    {
        if ($this->wishLists->removeElement($wishList)) {
            // set the owning side to null (unless already changed)
            if ($wishList->getUserUuid() === $this) {
                $wishList->setUserUuid(null);
            }
        }

        return $this;
    }
}
