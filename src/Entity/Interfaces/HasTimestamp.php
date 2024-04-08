<?php

namespace App\Entity\Interfaces;

use DateTimeInterface;

interface HasTimestamp
{
    public function getCreatedAt(): DateTimeInterface;

    public function getUpdatedAt(): ?DateTimeInterface;

    public function setCreatedAt(DateTimeInterface $createdAt): self;

    public function setUpdatedAt(DateTimeInterface $updatedAt): self;
}