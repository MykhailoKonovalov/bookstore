<?php

namespace App\DTO;

class BookDetailDTO
{
    public function __construct(
        public string $title,
        public string $author,
        public string $publisher,
        public array $categories,
        public string $language,
        public int $publishedYear,
        public int $pageCount,
        public string $description,
        public string $coverUrl,
        public bool $illustration,
        public bool $isSoftCover,
        public string $translator,
        public float $width,
        public float $height,
        public int $stockCount,
        public array $products = [],
    ) {}
}