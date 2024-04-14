<?php

namespace App\DTO;

class BooksListDTO
{
    public function __construct(
        public string $title,
        public int $priority,
        /** @var BookPreviewDTO[] */
        public array $books,
    ) {}
}