<?php

namespace App\Entity\Interfaces;

use App\Entity\BookCopy;

interface ProductInterface
{
    public function getBookCopy(): BookCopy;

    public function setBookCopy(BookCopy $bookCopy): self;

    public function getPrice(): string;

    public function setPrice(string $price): self;

    public function getDiscountPercent(): int;

    public function setDiscountPercent(int $discountPercent): self;

    public function getDiscountPrice(): string;

    public function setDiscountPrice(string $discountPrice): self;

    public function getSalesCount(): int;

    public function setSalesCount(int $salesCount): self;
}