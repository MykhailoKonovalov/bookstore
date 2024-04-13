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
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: PublisherRepository::class)]
#[ORM\Table(name: "publishers")]
#[ORM\UniqueConstraint(name: "UNIQ_IDENTIFIER_PUBLISHER_NAME", fields: ["name"])]
#[UniqueEntity(fields: ["name"], message: "This name is already exists")]
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
    #[ORM\OneToMany(mappedBy: "publisher", targetEntity: PaperBook::class)]
    private Collection $paperBooks;

    public function __construct()
    {
        $this->paperBooks = new ArrayCollection();
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
