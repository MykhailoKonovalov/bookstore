<?php

namespace App\Entity;

use App\Entity\Interfaces\HasTimestamp;
use App\Entity\Interfaces\ProductInterface;
use App\Entity\Traits\ProductTrait;
use App\Entity\Traits\TimestampTrait;
use App\Repository\AudioBooksRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AudioBooksRepository::class)]
#[ORM\Table(name: "audio_books")]
#[ORM\HasLifecycleCallbacks]
class AudioBook implements HasTimestamp, ProductInterface
{
    use TimestampTrait;

    use ProductTrait;

    #[ORM\Id]
    #[ORM\OneToOne(inversedBy: 'audioBook', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: "book_copy_uuid", referencedColumnName: "uuid", nullable: false)]
    private ?BookCopy $bookCopy = null;

    #[ORM\Column(type: Types::INTEGER)]
    private int $durationInMinutes;

    #[ORM\Column(type: Types::STRING)]
    private string $narrator;

    #[ORM\Column(type: Types::STRING)]
    private string $fileUrl;

    public function getBookCopy(): BookCopy
    {
        return $this->bookCopy;
    }

    public function setBookCopy(BookCopy $bookCopy): self
    {
        $this->bookCopy = $bookCopy;

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
