<?php

namespace App\Entity;

use App\Entity\Interfaces\HasTimestamp;
use App\Entity\Interfaces\HasUUID;
use App\Entity\Traits\TimestampTrait;
use App\Entity\Traits\UUIDTrait;
use App\Repository\AudioBooksRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AudioBooksRepository::class)]
#[ORM\Table(name: "audio_books")]
#[ORM\Index(name: "ab_book_idx", columns: ["book_slug"])]
#[ORM\HasLifecycleCallbacks]
class AudioBook implements HasUUID, HasTimestamp
{
    use UUIDTrait;

    use TimestampTrait;

    #[ORM\ManyToOne(inversedBy: "audioBooks")]
    #[ORM\JoinColumn(name: "book_slug", referencedColumnName: "slug", nullable: false, onDelete: "CASCADE")]
    private ?Book $book = null;

    #[ORM\Column(type: Types::INTEGER)]
    private int $durationInMinutes;

    #[ORM\Column(type: Types::STRING)]
    private string $narrator;

    #[ORM\Column(type: Types::STRING)]
    private string $fileUrl;

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): self
    {
        $this->book = $book;

        return $this;
    }

    public function getDurationInMinutes(): int
    {
        return $this->durationInMinutes;
    }

    public function setDurationInMinutes(int $durationInMinutes): self
    {
        $this->durationInMinutes = $durationInMinutes;

        return $this;
    }

    public function getNarrator(): string
    {
        return $this->narrator;
    }

    public function setNarrator(string $narrator): self
    {
        $this->narrator = $narrator;

        return $this;
    }

    public function getFileUrl(): string
    {
        return $this->fileUrl;
    }

    public function setFileUrl(string $fileUrl): self
    {
        $this->fileUrl = $fileUrl;

        return $this;
    }
}
