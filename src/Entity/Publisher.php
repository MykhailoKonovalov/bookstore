<?php

namespace App\Entity;

use App\Entity\Interfaces\HasSlug;
use App\Entity\Interfaces\HasTimestamp;
use App\Entity\Traits\SlugTrait;
use App\Entity\Traits\TimestampTrait;
use App\Repository\PublisherRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PublisherRepository::class)]
#[ORM\Table(name: "publishers")]
#[ORM\Index(columns: ["name"], name: "publisher_name_idx")]
#[ORM\HasLifecycleCallbacks]
class Publisher implements HasSlug, HasTimestamp
{
    use SlugTrait;

    use TimestampTrait;

    #[ORM\Column(type: Types::STRING)]
    private string $name;

    /**
     * @var Collection<int, PaperBook>
     */
    #[ORM\OneToMany(targetEntity: PaperBook::class, mappedBy: "publisher")]
    private Collection $paperBooks;

    public function __construct()
    {
        $this->paperBooks = new ArrayCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, PaperBook>
     */
    public function getPaperBooks(): Collection
    {
        return $this->paperBooks;
    }

    public function addBook(PaperBook $paperBook): self
    {
        if (!$this->paperBooks->contains($paperBook)) {
            $this->paperBooks->add($paperBook);
            $paperBook->setPublisher($this);
        }

        return $this;
    }

    public function removePaperBook(PaperBook $paperBooks): self
    {
        if ($this->paperBooks->removeElement($paperBooks)) {
            if ($paperBooks->getPublisher() === $this) {
                $paperBooks->setPublisher(null);
            }
        }

        return $this;
    }
}
