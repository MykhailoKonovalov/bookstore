<?php

namespace App\DTO;

class BooksListDTO
{
    public function __construct(
        public string $title,
        /** @var BookPreviewDTO[] */
        public array $books,
    ) {}
}