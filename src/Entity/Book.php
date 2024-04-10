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

    /**
     * @var Collection<int, AudioBook>
     */
    #[ORM\OneToMany(targetEntity: AudioBook::class, mappedBy: "book")]
    private Collection $audioBooks;

    /**
     * @var Collection<int, PaperBook>
     */
    #[ORM\OneToMany(targetEntity: PaperBook::class, mappedBy: "book")]
    private Collection $paperBooks;

    /**
     * @var Collection<int, EBook>
     */
    #[ORM\OneToMany(targetEntity: EBook::class, mappedBy: "book")]
    private Collection $eBooks;

    public function __construct()
    {
        $this->category = new ArrayCollection();
        $this->audioBooks = new ArrayCollection();
        $this->paperBooks = new ArrayCollection();
        $this->eBooks = new ArrayCollection();
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

    /**
     * @return Collection<int, AudioBook>
     */
    public function getAudioBooks(): Collection
    {
        return $this->audioBooks;
    }

    public function addAudioBook(AudioBook $audioBook): self
    {
        if (!$this->audioBooks->contains($audioBook)) {
            $this->audioBooks->add($audioBook);
            $audioBook->setBook($this);
        }

        return $this;
    }

    public function removeAudioBook(AudioBook $audioBook): self
    {
        if ($this->audioBooks->removeElement($audioBook)) {
            if ($audioBook->getBook() === $this) {
                $audioBook->setBook(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PaperBook>
     */
    public function getPaperBooks(): Collection
    {
        return $this->paperBooks;
    }

    public function addPaperBook(PaperBook $paperBook): self
    {
        if (!$this->paperBooks->contains($paperBook)) {
            $this->paperBooks->add($paperBook);
            $paperBook->setBook($this);
        }

        return $this;
    }

    public function removePaperBook(PaperBook $paperBook): self
    {
        if ($this->paperBooks->removeElement($paperBook)) {
            if ($paperBook->getBook() === $this) {
                $paperBook->setBook(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EBook>
     */
    public function getEBooks(): Collection
    {
        return $this->eBooks;
    }

    public function addEBook(EBook $eBook): self
    {
        if (!$this->eBooks->contains($eBook)) {
            $this->eBooks->add($eBook);
            $eBook->setBook($this);
        }

        return $this;
    }

    public function removeEBook(EBook $eBook): self
    {
        if ($this->eBooks->removeElement($eBook)) {
            if ($eBook->getBook() === $this) {
                $eBook->setBook(null);
            }
        }

        return $this;
    }
}
