<?php

namespace App\Entity;

use App\Entity\Interfaces\HasSlug;
use App\Entity\Interfaces\HasTimestamp;
use App\Entity\Traits\SlugTrait;
use App\Entity\Traits\TimestampTrait;
use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: AuthorRepository::class)]
#[ORM\Table(name: "authors")]
#[ORM\UniqueConstraint(name: "UNIQ_IDENTIFIER_AUTHOR_NAME", fields: ["name"])]
#[UniqueEntity(fields: ["name"], message: "This name is already exists")]
#[ORM\Index(columns: ["name"], name: "author_name_idx")]
#[ORM\HasLifecycleCallbacks]
class Author implements HasSlug, HasTimestamp
{
    use SlugTrait;

    use TimestampTrait;

    #[ORM\Column(type: Types::STRING)]
    private string $name;

    /**
     * @var Collection<int, Book>
     */
    #[ORM\OneToMany(mappedBy: "author", targetEntity: Book::class)]
    private Collection $books;

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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
            $book->setAuthor($this);
        }

        return $this;
    }

    public function removeBook(Book $book): self
    {
        if ($this->books->removeElement($book)) {
            if ($book->getAuthor() === $this) {
                $book->setAuthor(null);
            }
        }

        return $this;
    }
}
