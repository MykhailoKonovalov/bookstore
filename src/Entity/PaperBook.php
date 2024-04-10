<?php

namespace App\Entity;

use App\Entity\Interfaces\HasTimestamp;
use App\Entity\Interfaces\HasUUID;
use App\Entity\Interfaces\ProductInterface;
use App\Entity\Traits\ProductTrait;
use App\Entity\Traits\TimestampTrait;
use App\Entity\Traits\UUIDTrait;
use App\Repository\PaperBooksRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaperBooksRepository::class)]
#[ORM\Table(name: "paper_books")]
#[ORM\Index(name: 'pb_book_idx', columns: ['book_slug'])]
#[ORM\Index(name: "pb_publisher_idx", columns: ["publisher_slug"])]
#[ORM\HasLifecycleCallbacks]
class PaperBook implements HasUUID, HasTimestamp, ProductInterface
{
    use UUIDTrait;

    use TimestampTrait;

    use ProductTrait;

    #[ORM\ManyToOne(inversedBy: 'paperBooks')]
    #[ORM\JoinColumn(name: "book_slug", referencedColumnName: "slug", nullable: false, onDelete: "CASCADE")]
    private ?Book $book = null;

    #[ORM\ManyToOne(inversedBy: "paperBooks")]
    #[ORM\JoinColumn(name: "publisher_slug", referencedColumnName: "slug", nullable: false, onDelete: "CASCADE")]
    private ?Publisher $publisher = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private string $width;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private string $height;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    private bool $illustration = false;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    private bool $isSoftCover = false;

    #[ORM\Column(type: Types::INTEGER)]
    private int $pageCount;

    #[ORM\Column(type: Types::INTEGER, options: ["unsigned" => true])]
    private int $publishedYear;

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): self
    {
        $this->book = $book;

        return $this;
    }

    public function getPublisher(): ?Publisher
    {
        return $this->publisher;
    }

    public function setPublisher(?Publisher $publisher): self
    {
        $this->publisher = $publisher;

        return $this;
    }

    public function getWidth(): string
    {
        return $this->width;
    }

    public function setWidth(string $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): string
    {
        return $this->height;
    }

    public function setHeight(string $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function isIllustration(): bool
    {
        return $this->illustration;
    }

    public function setIllustration(bool $illustration): self
    {
        $this->illustration = $illustration;

        return $this;
    }

    public function isSoftCover(): bool
    {
        return $this->isSoftCover;
    }

    public function setIsSoftCover(bool $isSoftCover): self
    {
        $this->isSoftCover = $isSoftCover;

        return $this;
    }

    public function getPageCount(): int
    {
        return $this->pageCount;
    }

    public function setPageCount(int $pageCount): self
    {
        $this->pageCount = $pageCount;

        return $this;
    }

    public function getPublishedYear(): int
    {
        return $this->publishedYear;
    }

    public function setPublishedYear(int $publishedYear): self
    {
        $this->publishedYear = $publishedYear;

        return $this;
    }
}
