<?php

namespace App\Entity\Interfaces;

use Symfony\Component\Uid\Uuid;

interface HasUUID
{
    public function getUuid(): Uuid;

    public function setUuid(Uuid $uuid): self;

    public function getUuidAsString(): string;

    public function setUuidFromString(string $uuid): self;
}