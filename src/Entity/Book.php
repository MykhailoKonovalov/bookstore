<?php

namespace App\Entity;

use App\Entity\Interfaces\HasSlug;
use App\Entity\Interfaces\HasTimestamp;
use App\Entity\Traits\SlugTrait;
use App\Entity\Traits\TimestampTrait;
use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
#[ORM\Table(name: "books")]
#[ORM\Index(name: "book_title_idx", columns: ["title"])]
#[ORM\Index(name: "book_language_idx", columns: ["language"])]
#[ORM\Index(name: "book_author_idx", columns: ["author_slug"])]
#[ORM\HasLifecycleCallbacks]
class Book implements HasSlug, HasTimestamp
{
    use SlugTrait;

    use TimestampTrait;

    #[ORM\Column(type: Types::STRING)]
    private string $title;

    #[ORM\ManyToOne(inversedBy: "books")]
    #[ORM\JoinColumn(name: "author_slug", referencedColumnName: "slug", nullable: false, onDelete: "CASCADE")]
    private ?Author $author = null;

    /**
     * @var Collection<int, Category>
     */
    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: "books")]
    #[ORM\JoinTable(name: "categories_books")]
    #[ORM\JoinColumn(name: "book_slug", referencedColumnName: "slug")]
    #[ORM\InverseJoinColumn("category_slug", referencedColumnName: "slug")]
    private Collection $category;

    #[ORM\Column(type: Types::TEXT, length: 65535, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $translator = null;

    #[ORM\Column(type: Types::STRING, length: 2)]
    private string $language;

    #[ORM\Column(type: Types::INTEGER, options: ['unsigned' => true, 'default' => 0, 'max' => 5])]
    private int $rating = 0;

    /**
     * @var Collection<int, Review>
     */
    #[ORM\OneToMany(targetEntity: Review::class, mappedBy: 'book', orphanRemoval: true)]
    private Collection $reviews;

    /**
     * @var Collection<int, BookCopy>
     */
    #[ORM\OneToMany(targetEntity: BookCopy::class, mappedBy: 'book', orphanRemoval: true)]
    private Collection $bookCopies;

    public function __construct()
    {
        $this->category = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->bookCopies = new ArrayCollection();
    }

    private function getValueToSlugify(): string
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

    /**
     * @return Collection<int, BookCopy>
     */
    public function getBookCopies(): Collection
    {
        return $this->bookCopies;
    }

    public function addBookCopy(BookCopy $bookCopy): self
    {
        if (!$this->bookCopies->contains($bookCopy)) {
            $this->bookCopies->add($bookCopy);
            $bookCopy->setBook($this);
        }

        return $this;
    }

    public function removeBookType(BookCopy $bookCopy): self
    {
        if ($this->bookCopies->removeElement($bookCopy)) {
            if ($bookCopy->getBook() === $this) {
                $bookCopy->setBook(null);
            }
        }

        return $this;
    }
}
