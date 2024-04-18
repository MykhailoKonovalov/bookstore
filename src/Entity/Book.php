<?php

namespace App\Entity;

use App\Constant\BookTypes;
use App\Entity\Interfaces\HasSlug;
use App\Entity\Interfaces\HasTimestamp;
use App\Entity\Traits\SlugTrait;
use App\Entity\Traits\TimestampTrait;
use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[ORM\Entity(repositoryClass: BookRepository::class)]
#[ORM\Table(name: "books")]
#[ORM\UniqueConstraint(name: "UNIQ_IDENTIFIER_BOOK_TITLE", fields: ["title"])]
#[UniqueEntity(fields: ["title"], message: "This title is already exists")]
#[ORM\Index(columns: ["title"], name: "book_title_idx")]
#[ORM\Index(columns: ["language"], name: "book_language_idx")]
#[ORM\Index(columns: ["author_slug"], name: "book_author_idx")]
#[ORM\HasLifecycleCallbacks]
class Book implements HasSlug, HasTimestamp
{
    use SlugTrait;

    use TimestampTrait;

    #[ORM\Id]
    #[ORM\Column(type: Types::STRING, unique: true)]
    private string $slug;

    #[ORM\Column(type: Types::STRING)]
    private string $title;

    #[ORM\ManyToOne(inversedBy: "books")]
    #[ORM\JoinColumn(name: "author_slug", referencedColumnName: "slug", onDelete: "SET NULL")]
    private ?Author $author = null;

    /**
     * @var Collection<int, Category>
     */
    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: "books")]
    #[ORM\JoinTable(name: "categories_books")]
    #[ORM\JoinColumn(name: "book_slug", referencedColumnName: "slug", nullable: false)]
    #[ORM\InverseJoinColumn("category_slug", referencedColumnName: "slug")]
    private Collection $category;

    #[ORM\Column(type: Types::TEXT, length: 65535, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $translator = null;

    #[ORM\Column(type: Types::STRING, length: 3)]
    private string $language;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $coverUrl = null;

    #[ORM\Column(type: Types::INTEGER, options: ['unsigned' => true, 'default' => 0, 'max' => 5])]
    private int $rating = 0;

    #[ORM\ManyToOne(inversedBy: "books")]
    #[ORM\JoinColumn(name: "publisher_slug", referencedColumnName: "slug", onDelete: "SET NULL")]
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

    /**
     * @var Collection<int, Review>
     */
    #[ORM\OneToMany(mappedBy: 'book', targetEntity: Review::class, cascade: ["persist", "remove"], orphanRemoval: true)]
    private Collection $reviews;

    /**
     * @var Collection<int, Product>
     */
    #[ORM\OneToMany(mappedBy: 'book', targetEntity: Product::class, cascade: ["persist", "remove"], orphanRemoval: true)]
    private Collection $products;

    public function __construct()
    {
        $this->category = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->products = new ArrayCollection();
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function generateSlug(): void
    {
        $slugger = new AsciiSlugger();
        $slug = $slugger->slug($this->title);

        $this->slug = $slug;
    }

    public function __toString(): string
    {
        return $this->title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->category->contains($category)) {
            $this->category->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->category->removeElement($category);

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTranslator(): ?string
    {
        return $this->translator;
    }

    public function setTranslator(?string $translator): self
    {
        $this->translator = $translator;

        return $this;
    }
    
    public function getLanguage(): string
    {
        return $this->language;
    }

    public function setLanguage(string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews->add($review);
            $review->setBook($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            if ($review->getBook() === $this) {
                $review->setBook(null);
            }
        }

        return $this;
    }

    public function getCoverUrl(): ?string
    {
        return $this->coverUrl;
    }

    public function setCoverUrl(?string $coverUrl): self
    {
        $this->coverUrl = $coverUrl;

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

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setBook($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getBook() === $this) {
                $product->setBook(null);
            }
        }

        return $this;
    }

    public function getPaperBook(): false|Product
    {
        return $this->getProducts()->filter(
            function (Product $product) {
                return $product->getType() === BookTypes::PAPER->value;
            }
        )->first();
    }

    public function setPaperBook(Product $product): self
    {
        if (!$this->getPaperBook()) {
            $this->addProduct($product);
        }

        return $this;
    }

    public function getEBook(): false|Product
    {
        return $this->getProducts()->filter(
            function (Product $product) {
                return $product->getType() === BookTypes::ELECTRONIC->value;
            }
        )->first();
    }

    public function getGeneralSalesCount(): int
    {
        return array_reduce($this->getProducts()->toArray(), function ($carry, Product $product) {
            return $carry + $product->getSalesCount();
        }, 0);
    }
}
