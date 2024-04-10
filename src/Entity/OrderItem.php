<?php

namespace App\Entity;

use App\Repository\OrderItemRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderItemRepository::class)]
class OrderItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orderItems')]
    #[ORM\JoinColumn(name: 'order_uuid', referencedColumnName: 'uuid', nullable: false, onDelete: 'CASCADE')]
    private ?Order $orderUuid = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'book_copy_uuid', referencedColumnName: 'uuid', nullable: false)]
    private ?BookCopy $bookCopy = null;

    #[ORM\Column(type: Types::INTEGER, options: ['unsigned' => true])]
    private int $quantity = 0;

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

    public function getBookCopy(): ?BookCopy
    {
        return $this->bookCopy;
    }

    public function setBookCopy(?BookCopy $bookCopy): self
    {
        $this->bookCopy = $bookCopy;

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
}
