<?php

namespace App\Entity;

use App\Entity\Interfaces\HasTimestamp;
use App\Entity\Traits\TimestampTrait;
use App\Repository\BookListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: BookListRepository::class)]
#[ORM\Table(name: 'book_lists')]
#[ORM\UniqueConstraint(name: "UNIQ_IDENTIFIER_BOOK_LIST_PRIORITY", fields: ["priority"])]
#[ORM\UniqueConstraint(name: "UNIQ_IDENTIFIER_BOOK_LIST_NAME_PUB", fields: ['title', 'published'])]
#[UniqueEntity(fields: ['priority'], message: 'This priority already exists.')]
#[UniqueEntity(fields: ['title', 'published'], message: 'Book List with the same title already published.')]
class BookList implements HasTimestamp
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, nullable: false)]
    private string $title;

    #[ORM\Column(type: Types::INTEGER, nullable: false, options: ['unsigned' => true])]
    private int $priority = 0;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    private bool $published = false;

    /**
     * @var Collection<int, Book>
     */
    #[ORM\ManyToMany(targetEntity: Book::class)]
    #[ORM\JoinTable(name: "books_list_books")]
    #[ORM\JoinColumn("book_list_id", referencedColumnName: "id", nullable: false)]
    #[ORM\InverseJoinColumn(name: "book_slug", referencedColumnName: "slug", nullable: false)]
    private Collection $books;

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function isPublished(): bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): self
    {
        $this->published = $published;

        return $this;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): self
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
        }

        return $this;
    }

    public function removeBook(Book $book): self
    {
        $this->books->removeElement($book);

        return $this;
    }
}
