<?php

namespace App\DTO;

class ProductDTO
{
    public function __construct(
        public string $type,
        public float $price,
        public float $discountPrice,
        public int $discountPercentage = 0,
        public array $formats = [],
    ) {}
}