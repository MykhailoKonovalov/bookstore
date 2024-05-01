<?php

namespace App\DTO;

class CategoryDTO
{
    public function __construct(
        public string $slug,
        public string $name,
    ) {}
}