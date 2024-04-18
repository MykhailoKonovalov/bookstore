<?php

namespace App\Entity;

use App\Entity\Interfaces\HasTimestamp;
use App\Entity\Traits\TimestampTrait;
use App\Repository\OrderItemRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderItemRepository::class)]
#[ORM\Table(name: 'order_items')]
#[ORM\Index(columns: ["order_uuid"], name: "order_idx")]
#[ORM\Index(columns: ["product_uuid"], name: "order_product_idx")]
#[ORM\HasLifecycleCallbacks]
class OrderItem implements HasTimestamp
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orderItems')]
    #[ORM\JoinColumn(name: 'order_uuid', referencedColumnName: 'uuid', nullable: false, onDelete: 'CASCADE')]
    private ?Order $orderUuid = null;

    #[ORM\Column(type: Types::INTEGER, options: ['unsigned' => true])]
    private int $quantity = 0;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'product_uuid', referencedColumnName: 'uuid', nullable: false, onDelete: 'CASCADE')]
    private ?Product $product = null;

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

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }
}
