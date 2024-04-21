<?php

namespace App\Entity;

use App\Entity\Interfaces\HasTimestamp;
use App\Entity\Traits\TimestampTrait;
use App\Repository\CompilationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Validation\PublishedCompilationsLimit as CompilationsLimit;

#[ORM\Entity(repositoryClass: CompilationRepository::class)]
#[ORM\Table(name: 'compilations')]
#[ORM\UniqueConstraint(name: "UNIQ_IDENTIFIER_COMPILATION_PRIORITY", fields: ["priority"])]
#[ORM\UniqueConstraint(name: "UNIQ_IDENTIFIER_COMPILATION_NAME_PUB", fields: ['title', 'published'])]
#[UniqueEntity(fields: ['priority'], message: 'This priority already exists.')]
#[UniqueEntity(fields: ['title', 'published'], message: 'Compilation with the same title already published.')]
#[CompilationsLimit\CompilationsLimit(limit: 10)]
class Compilation implements HasTimestamp
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
    #[ORM\JoinTable(name: "compilations_books")]
    #[ORM\JoinColumn("compilation_id", referencedColumnName: "id", nullable: false)]
    #[ORM\InverseJoinColumn(name: "book_slug", referencedColumnName: "slug", nullable: false)]
    private Collection $books;

    #[ORM\Column(type: Types::STRING, length: 7, nullable: false)]
    private string $stickerColor;

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

    public function getStickerColor(): ?string
    {
        return $this->stickerColor;
    }

    public function setStickerColor(string $stickerColor): static
    {
        $this->stickerColor = $stickerColor;

        return $this;
    }
}
