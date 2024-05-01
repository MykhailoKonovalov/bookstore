<?php

namespace App\DTO;

class BookPreviewDTO
{
    public function __construct(
        public string $slug,
        public string $title,
        public string $coverUrl,
        public AuthorDTO $author,
        public ?string $price = null,
        public ?string $discountPrice = null,
        public int $discountPercentage = 0,
        public ?string $type = null,
    ) {}
}