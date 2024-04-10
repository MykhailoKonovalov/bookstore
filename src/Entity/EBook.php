<?php

namespace App\Entity;

use App\Entity\Interfaces\HasTimestamp;
use App\Entity\Interfaces\HasUUID;
use App\Entity\Interfaces\ProductInterface;
use App\Entity\Traits\ProductTrait;
use App\Entity\Traits\TimestampTrait;
use App\Entity\Traits\UUIDTrait;
use App\Repository\EBooksRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EBooksRepository::class)]
#[ORM\Table(name: "ebooks")]
#[ORM\Index(name: 'eb_book_idx', columns: ['book_slug'])]
#[ORM\Index(name: 'eb_format_idx', columns: ['format'])]
#[ORM\HasLifecycleCallbacks]
class EBook implements HasUUID, HasTimestamp, ProductInterface
{
    use UUIDTrait;

    use TimestampTrait;

    use ProductTrait;

    #[ORM\ManyToOne(inversedBy: 'eBooks')]
    #[ORM\JoinColumn(name: "book_slug", referencedColumnName: "slug", nullable: false, onDelete: "CASCADE")]
    private ?Book $book = null;

    #[ORM\Column(type: Types::STRING, length: 5)]
    private string $format;

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

    public function getFormat(): ?string
    {
        return $this->format;
    }

    public function setFormat(string $format): self
    {
        $this->format = $format;

        return $this;
    }

    public function getFileUrl(): ?string
    {
        return $this->fileUrl;
    }

    public function setFileUrl(string $fileUrl): self
    {
        $this->fileUrl = $fileUrl;

        return $this;
    }
}
