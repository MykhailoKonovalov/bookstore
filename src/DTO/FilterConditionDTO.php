<?php

namespace App\DTO;

class FilterConditionDTO
{
    public function __construct(
        public string $column,
        public string $value,
    ) {}
}