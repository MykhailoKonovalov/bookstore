<?php

namespace App\Entity;

use App\Constant\BookTypes;
use App\Entity\Interfaces\HasTimestamp;
use App\Entity\Interfaces\HasUUID;
use App\Entity\Interfaces\ProductInterface;
use App\Entity\Traits\ProductTrait;
use App\Entity\Traits\TimestampTrait;
use App\Entity\Traits\UUIDTrait;
use App\Repository\AudioBooksRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AudioBooksRepository::class)]
#[ORM\Table(name: "audio_books")]
#[ORM\HasLifecycleCallbacks]
class AudioBook implements HasUUID, HasTimestamp, ProductInterface
{
    use UUIDTrait;

    use TimestampTrait;

    use ProductTrait;

    #[ORM\Column(type: Types::INTEGER)]
    private int $durationInMinutes;

    #[ORM\Column(type: Types::STRING)]
    private string $narrator;

    #[ORM\Column(type: Types::STRING)]
    private string $fileUrl;

    #[ORM\OneToOne(mappedBy: 'audioBook', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: "book_slug", referencedColumnName: "slug", nullable: false)]
    private ?Book $book = null;

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

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): self
    {
        // unset the owning side of the relation if necessary
        if ($book === null && $this->book !== null) {
            $this->book->setAudioBook(null);
        }

        // set the owning side of the relation if necessary
        if ($book !== null && $book->getAudioBook() !== $this) {
            $book->setAudioBook($this);
        }

        $this->book = $book;

        return $this;
    }

    public function getBookType(): string
    {
        return BookTypes::AUDIO_BOOK->value;
    }
}
