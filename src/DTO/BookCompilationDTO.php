<?php

namespace App\DTO;

class BookCompilationDTO
{
    public function __construct(
        public string $title,
        /** @var BookPreviewDTO[] */
        public array $books,
    ) {}
}