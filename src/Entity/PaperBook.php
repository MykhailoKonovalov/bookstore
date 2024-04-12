<?php

namespace App\Entity;

use App\Entity\Interfaces\HasTimestamp;
use App\Entity\Interfaces\ProductInterface;
use App\Entity\Traits\ProductTrait;
use App\Entity\Traits\TimestampTrait;
use App\Repository\PaperBooksRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaperBooksRepository::class)]
#[ORM\Table(name: "paper_books")]
#[ORM\Index(columns: ["publisher_slug"], name: "pb_publisher_idx")]
#[ORM\HasLifecycleCallbacks]
class PaperBook implements HasTimestamp, ProductInterface
{
    use TimestampTrait;

    use ProductTrait;

    #[ORM\Id]
    #[ORM\OneToOne(inversedBy: 'paperBook', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: "book_copy_uuid", referencedColumnName: "uuid", nullable: false)]
    private ?BookCopy $bookCopy = null;

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

    #[ORM\Column(type: Types::INTEGER, options: ["unsigned" => true, 'default' => 0])]
    private int $stockCount = 0;

    public function __toString(): string
    {
        return $this->getBookCopy()->getBook()->getTitle();
    }

    public function getBookCopy(): BookCopy
    {
        return $this->bookCopy;
    }

    public function setBookCopy(BookCopy $bookCopy): self
    {
        $this->bookCopy = $bookCopy;

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

    public function getStockCount(): int
    {
        return $this->stockCount;
    }

    public function setStockCount(int $stockCount): self
    {
        $this->stockCount = $stockCount;

        return $this;
    }
}
