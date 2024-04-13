<?php

namespace App\Entity;

use App\Constant\BookTypes;
use App\Repository\OrderItemRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderItemRepository::class)]
#[ORM\Table(name: 'order_items')]
class OrderItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orderItems')]
    #[ORM\JoinColumn(name: 'order_uuid', referencedColumnName: 'uuid', nullable: false, onDelete: 'CASCADE')]
    private ?Order $orderUuid = null;

    #[ORM\Column(type: Types::INTEGER, options: ['unsigned' => true])]
    private int $quantity = 0;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: "book_slug", referencedColumnName: "slug", nullable: false)]
    private ?Book $book = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: false, enumType: BookTypes::class)]
    private BookTypes $bookType;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderUuid(): ?Order
    {
        return $this->orderUuid;
    }

    public function setOrderUuid(?Order $orderUuid): self
    {
        $this->orderUuid = $orderUuid;

        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
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

    public function getBookType(): string
    {
        return $this->bookType->value;
    }

    public function setBookType(BookTypes $bookType): self
    {
        $this->bookType = $bookType;

        return $this;
    }
}
