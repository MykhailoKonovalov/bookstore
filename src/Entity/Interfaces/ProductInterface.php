<?php

namespace App\Entity\Interfaces;

use App\Entity\Book;

interface ProductInterface
{
    public function getBook(): ?Book;

    public function setBook(Book $book): self;

    public function getPrice(): string;

    public function setPrice(string $price): self;

    public function getDiscountPercent(): int;

    public function setDiscountPercent(int $discountPercent): self;

    public function getDiscountPrice(): string;

    public function setDiscountPrice(string $discountPrice): self;

    public function getSalesCount(): int;

    public function setSalesCount(int $salesCount): self;
}