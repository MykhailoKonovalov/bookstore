<?php

namespace App\Entity;

use App\Repository\WishListRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: WishListRepository::class)]
#[ORM\Table(name: 'wish_lists')]
#[ORM\UniqueConstraint(name: "UNIQ_IDENTIFIER_BOOK_USER", fields: ["bookSlug", "userUuid"])]
#[UniqueEntity(fields: ["book_slug", "user_uuid"], message: "This book is already in wish list")]
#[ORM\HasLifecycleCallbacks]
class WishList
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'book_slug', referencedColumnName: 'slug', nullable: false)]
    private ?Book $bookSlug = null;

    #[ORM\ManyToOne(inversedBy: 'wishLists')]
    #[ORM\JoinColumn(name: 'user_uuid', referencedColumnName: 'uuid', nullable: false)]
    private ?User $userUuid = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBookSlug(): ?Book
    {
        return $this->bookSlug;
    }

    public function setBookSlug(?Book $bookSlug): self
    {
        $this->bookSlug = $bookSlug;

        return $this;
    }

    public function getUserUuid(): ?User
    {
        return $this->userUuid;
    }

    public function setUserUuid(?User $userUuid): self
    {
        $this->userUuid = $userUuid;

        return $this;
    }
}
