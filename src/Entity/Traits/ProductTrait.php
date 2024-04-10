<?php

namespace App\Entity\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait ProductTrait
{
    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private string $price;

    #[ORM\Column(type: Types::INTEGER, options: ['unsigned' => true, 'max' => 100, 'default' => 0])]
    private int $discountPercent = 0;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private string $discountPrice;

    #[ORM\Column(type: Types::INTEGER, options: ['unsigned' => true, 'default' => 0])]
    private int $salesCount = 0;

    public function getPrice(): string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDiscountPercent(): int
    {
        return $this->discountPercent;
    }

    public function setDiscountPercent(int $discountPercent): self
    {
        $this->discountPercent = $discountPercent;

        return $this;
    }

    public function getDiscountPrice(): string
    {
        return $this->discountPrice;
    }

    public function setDiscountPrice(string $discountPrice): self
    {
        $this->discountPrice = $discountPrice;

        return $this;
    }

    public function getSalesCount(): int
    {
        return $this->salesCount;
    }

    public function setSalesCount(int $salesCount): self
    {
        $this->salesCount = $salesCount;

        return $this;
    }
}