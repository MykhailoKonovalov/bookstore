<?php

namespace App\Entity;

use App\Constant\BookTypes;
use App\Entity\Interfaces\HasTimestamp;
use App\Entity\Interfaces\HasUUID;
use App\Entity\Traits\TimestampTrait;
use App\Entity\Traits\UUIDTrait;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\Table(name: 'products')]
#[ORM\UniqueConstraint(name: "UNIQ_IDENTIFIER_BOOK_TYPE", fields: ["type", "book"])]
#[UniqueEntity(fields: ["type", "book"], message: "This type is already exists for this book")]
#[ORM\HasLifecycleCallbacks]
class Product implements HasUUID, HasTimestamp
{
    public const CURRENCY_CODE = 'UAH';

    use UUIDTrait;

    use TimestampTrait;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(name: "book_slug", referencedColumnName: "slug", nullable: false, onDelete: "CASCADE")]
    private ?Book $book = null;

    #[ORM\Column(
        type: Types::STRING,
        length: 10,
        enumType: BookTypes::class,
        options: ['default' => BookTypes::PAPER_BOOK->value]
    )]
    private BookTypes $type = BookTypes::PAPER_BOOK;

    #[ORM\Column(type: Types::INTEGER, options: ['unsigned' => true])]
    private string $price;

    #[ORM\Column(type: Types::INTEGER, options: ['unsigned' => true, 'default' => 0])]
    private int $discountPercent = 0;

    #[ORM\Column(type: Types::INTEGER, options: ['unsigned' => true])]
    private string $discountPrice;

    #[ORM\Column(type: Types::INTEGER, options: ['unsigned' => true, 'default' => 0])]
    private int $salesCount = 0;

    /**
     * @var Collection<int, EBookFormat>
     */
    #[ORM\OneToMany(mappedBy: 'product', targetEntity: EBookFormat::class, orphanRemoval: true)]
    private Collection $eBookFormats;

    public function __construct()
    {
        $this->eBookFormats = new ArrayCollection();
    }

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

    public function getPrice(): string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDiscountPercent(): int
    {
        return $this->discountPercent;
    }

    public function setDiscountPercent(int $discountPercent): self
    {
        $this->discountPercent = $discountPercent;

        return $this;
    }

    public function getDiscountPrice(): string
    {
        return $this->discountPrice;
    }

    public function setDiscountPrice(string $discountPrice): self
    {
        $this->discountPrice = $discountPrice;

        return $this;
    }

    public function getSalesCount(): int
    {
        return $this->salesCount;
    }

    public function setSalesCount(int $salesCount): self
    {
        $this->salesCount = $salesCount;

        return $this;
    }

    public function __toString(): string
    {
        return sprintf('%s - %s book', $this->getBook()->getTitle(), $this->getType());
    }

    /**
     * @return Collection<int, EBookFormat>
     */
    public function getEBookFormats(): Collection
    {
        return $this->eBookFormats;
    }

    public function addEBookFormat(EBookFormat $eBookFormat): static
    {
        if (!$this->eBookFormats->contains($eBookFormat)) {
            $this->eBookFormats->add($eBookFormat);
            $eBookFormat->setProduct($this);
        }

        return $this;
    }

    public function removeEBookFormat(EBookFormat $eBookFormat): static
    {
        if ($this->eBookFormats->removeElement($eBookFormat)) {
            // set the owning side to null (unless already changed)
            if ($eBookFormat->getProduct() === $this) {
                $eBookFormat->setProduct(null);
            }
        }

        return $this;
    }
}
