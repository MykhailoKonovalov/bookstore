<?php

namespace App\DTO;

class BookPreviewDTO
{
    public function __construct(
        public string $slug,
        public string $title,
        public string $coverUrl,
        public string $author,
        public ?string $price = null,
        public ?string $discountPrice = null,
    ) {}
}