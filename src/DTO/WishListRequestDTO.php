<?php

namespace App\DTO;

class WishListRequestDTO
{
    public function __construct(
        public string $bookSlug,
    ) {}
}