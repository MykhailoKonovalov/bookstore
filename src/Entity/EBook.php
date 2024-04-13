<?php

namespace App\Entity;

use App\Constant\BookTypes;
use App\Entity\Interfaces\HasTimestamp;
use App\Entity\Interfaces\HasUUID;
use App\Entity\Interfaces\ProductInterface;
use App\Entity\Traits\ProductTrait;
use App\Entity\Traits\TimestampTrait;
use App\Entity\Traits\UUIDTrait;
use App\Repository\EBooksRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EBooksRepository::class)]
#[ORM\Table(name: "ebooks")]
#[ORM\HasLifecycleCallbacks]
class EBook implements HasUUID, HasTimestamp, ProductInterface
{
    use UUIDTrait;

    use TimestampTrait;

    use ProductTrait;

    /**
     * @var Collection<int, EBookFormat>
     */
    #[ORM\OneToMany(mappedBy: 'eBook', targetEntity: EBookFormat::class, orphanRemoval: true)]
    private Collection $eBookFormats;

    #[ORM\OneToOne(mappedBy: 'eBook', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: "book_slug", referencedColumnName: "slug", nullable: false, onDelete: "cascade")]
    private ?Book $book = null;

    public function __construct()
    {
        $this->eBookFormats = new ArrayCollection();
    }

    /**
     * @return Collection<int, EBookFormat>
     */
    public function getEBookFormats(): Collection
    {
        return $this->eBookFormats;
    }

    public function addEBookFormat(EBookFormat $eBookFormat): self
    {
        if (!$this->eBookFormats->contains($eBookFormat)) {
            $this->eBookFormats->add($eBookFormat);
            $eBookFormat->setEbookUuid($this);
        }

        return $this;
    }

    public function removeEBookFormat(EBookFormat $eBookFormat): self
    {
        if ($this->eBookFormats->removeElement($eBookFormat)) {
            if ($eBookFormat->getEbookUuid() === $this) {
                $eBookFormat->setEbookUuid(null);
            }
        }

        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): self
    {
        if ($book === null && $this->book !== null) {
            $this->book->setEBook(null);
        }

        if ($book !== null && $book->getEBook() !== $this) {
            $book->setEBook($this);
        }

        $this->book = $book;

        return $this;
    }

    public function getBookType(): string
    {
        return BookTypes::ELECTRONIC_BOOK->value;
    }
}
