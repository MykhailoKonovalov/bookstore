<?php

namespace App\Entity;

use App\Constant\OrderStatuses;
use App\Entity\Interfaces\HasTimestamp;
use App\Entity\Interfaces\HasUUID;
use App\Entity\Traits\TimestampTrait;
use App\Entity\Traits\UUIDTrait;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: 'orders')]
#[ORM\Index(columns: ["user_uuid"], name: "order_user_idx")]
#[ORM\Index(columns: ["status"], name: "order_status_idx")]
#[ORM\HasLifecycleCallbacks]
class Order implements HasUUID, HasTimestamp
{
    use UUIDTrait;

    use TimestampTrait;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(name: "user_uuid", referencedColumnName: "uuid", nullable: false)]
    private ?User $userUuid = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, options: ['default' => '0.00'])]
    private string $totalPrice = '0.00';

    #[ORM\Column(type: Types::STRING, length: 32, enumType: OrderStatuses::class, options: ['default' => OrderStatuses::STARTED])]
    private OrderStatuses $status;

    /**
     * @var Collection<int, OrderItem>
     */
    #[ORM\OneToMany(mappedBy: 'orderUuid', targetEntity: OrderItem::class, orphanRemoval: true)]
    private Collection $orderItems;

    public function __construct()
    {
        $this->orderItems = new ArrayCollection();
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

    public function getTotalPrice(): ?string
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(string $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getStatus(): OrderStatuses
    {
        return $this->status;
    }

    public function setStatus(OrderStatuses $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, OrderItem>
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    public function addOrderItem(OrderItem $orderItem): self
    {
        if (!$this->orderItems->contains($orderItem)) {
            $this->orderItems->add($orderItem);
            $orderItem->setOrderUuid($this);
        }

        return $this;
    }

    public function removeOrderItem(OrderItem $orderItem): self
    {
        if ($this->orderItems->removeElement($orderItem)) {
            if ($orderItem->getOrderUuid() === $this) {
                $orderItem->setOrderUuid(null);
            }
        }

        return $this;
    }
}
