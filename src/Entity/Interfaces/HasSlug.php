<?php

namespace App\Entity\Interfaces;

interface HasSlug
{
    public function getSlug(): string;

    public function setSlug(string $slug): void;
}