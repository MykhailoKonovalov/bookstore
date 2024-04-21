<?php

namespace App\DTO;

class BookCompilationDTO
{
    public function __construct(
        public string $title,
        public string $color,
        /** @var BookPreviewDTO[] */
        public array $books,
    ) {}
}