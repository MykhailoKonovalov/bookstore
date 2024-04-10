<?php

namespace App\Entity;

use App\Entity\Interfaces\HasTimestamp;
use App\Entity\Traits\TimestampTrait;
use App\Repository\ReviewRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReviewRepository::class)]
#[ORM\Table(name: "reviews")]
#[ORM\Index(name: "review_book_idx", columns: ["book_slug"])]
#[ORM\Index(name: "review_user_idx", columns: ["user_uuid"])]
#[ORM\HasLifecycleCallbacks]
class Review implements HasTimestamp
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'reviews')]
    #[ORM\JoinColumn(name: "book_slug", referencedColumnName: "slug", nullable: false, onDelete: "CASCADE")]
    private ?Book $book = null;

    #[ORM\ManyToOne(inversedBy: 'reviews')]
    #[ORM\JoinColumn(name: "user_uuid", referencedColumnName: "uuid", nullable: false, onDelete: "CASCADE")]
    private ?User $userUuid = null;

    #[ORM\Column(type: Types::INTEGER, options: ['unsigned' => true, 'default' => 0, 'max' => 5])]
    private int $rating = 0;

    #[ORM\Column(type: Types::TEXT, length: 65535, nullable: true)]
    private ?string $text = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): self
    {
        $this->book = $book;

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

    public function getRating(): int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }
}
