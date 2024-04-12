<?php

namespace App\Entity;

use App\Constant\BookTypes;
use App\Entity\Interfaces\HasUUID;
use App\Entity\Traits\UUIDTrait;
use App\Repository\BookCopyRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookCopyRepository::class)]
#[ORM\Table(name: 'book_copies')]
#[ORM\Index(columns: ['book_slug'], name: 'book_copies_books_idx')]
#[ORM\Index(columns: ['type'], name: 'book_copies_type_idx')]
#[ORM\HasLifecycleCallbacks]
class BookCopy implements HasUUID
{
    use UUIDTrait;

    #[ORM\ManyToOne(inversedBy: 'bookCopies')]
    #[ORM\JoinColumn(name: "book_slug", referencedColumnName: "slug", nullable: false, onDelete: "CASCADE")]
    private ?Book $book = null;

    #[ORM\Column(type: Types::STRING, length: 16, enumType: BookTypes::class)]
    private BookTypes $type;

    #[ORM\OneToOne(mappedBy: 'bookCopy', cascade: ['persist', 'remove'])]
    private ?AudioBook $audioBook = null;

    #[ORM\OneToOne(mappedBy: 'bookCopy', cascade: ['persist', 'remove'])]
    private ?PaperBook $paperBook = null;

    #[ORM\OneToOne(mappedBy: 'bookCopy', cascade: ['persist', 'remove'])]
    private ?EBook $eBook = null;

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): self
    {
        $this->book = $book;

        return $this;
    }

    public function getType(): string
    {
        return $this->type->value;
    }

    public function setType(BookTypes $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getAudioBook(): ?AudioBook
    {
        return $this->type == BookTypes::AUDIO_BOOK ? $this->audioBook : null;
    }

    public function setAudioBook(AudioBook $audioBook): self
    {
        if ($this->type == BookTypes::AUDIO_BOOK) {
            if ($audioBook->getBookCopy() !== $this) {
                $audioBook->setBookCopy($this);
            }

            $this->audioBook = $audioBook;
        }

        return $this;
    }

    public function getPaperBook(): ?PaperBook
    {
        return $this->type == BookTypes::PAPER_BOOK ? $this->paperBook : null;
    }

    public function setPaperBook(PaperBook $paperBook): self
    {
        if ($this->type == BookTypes::PAPER_BOOK) {
            if ($paperBook->getBookCopy() !== $this) {
                $paperBook->setBookCopy($this);
            }

            $this->paperBook = $paperBook;
        }

        return $this;
    }

    public function getEBook(): ?EBook
    {
        return $this->type == BookTypes::ELECTRONIC_BOOK ? $this->eBook : null;
    }

    public function setEBook(EBook $eBook): self
    {
        if ($this->type == BookTypes::ELECTRONIC_BOOK) {
            if ($eBook->getBookCopy() !== $this) {
                $eBook->setBookCopy($this);
            }

            $this->eBook = $eBook;
        }

        return $this;
    }
}
