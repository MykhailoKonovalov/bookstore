<?php

namespace App\Entity\Interfaces;

interface CachedEntityInterface
{
    public function getCacheKey(): string;
}