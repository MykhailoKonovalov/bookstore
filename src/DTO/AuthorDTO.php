<?php

namespace App\DTO;

class AuthorDTO
{
    public function __construct(
        public string $slug,
        public string $name,
    ) {}
}