<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Uid\Uuid;

trait UUIDTrait
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $uuid;

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function setUuid(Uuid $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getUuidAsString(): string
    {
        return $this->uuid->toRfc4122();
    }

    public function setUuidFromString(string $uuidString): self
    {
        $this->uuid = Uuid::fromString($uuidString);

        return $this;
    }

    #[ORM\PrePersist]
    public function setUuidOnCreate(): void
    {
        $this->uuid = Uuid::v4();
    }
}