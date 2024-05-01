<?php

namespace App\DTO;

class PublisherDTO
{
    public function __construct(
        public string $slug,
        public string $name,
    ) {}
}