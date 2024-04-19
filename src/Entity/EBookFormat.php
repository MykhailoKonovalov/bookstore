<?php

namespace App\Entity;

use App\Repository\EBookFormatRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: EBookFormatRepository::class)]
#[ORM\Table(name: "ebook_formats")]
#[ORM\UniqueConstraint(name: "UNIQ_IDENTIFIER_BOOK_FORMAT", fields: ["format", 'product'])]
#[UniqueEntity(fields: ["format", 'product'], message: "This format is already exists for this book")]
class EBookFormat
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 4)]
    private string $format;

    #[ORM\Column(type: Types::STRING)]
    private string $fileUrl;

    #[ORM\ManyToOne(cascade: ['persist'], inversedBy: 'eBookFormats')]
    #[ORM\JoinColumn(name: "product_uuid", referencedColumnName: "uuid", nullable: false, onDelete: "CASCADE")]
    private ?Product $product = null;

    public function __toString(): string
    {
        return sprintf('#%d: %s - %s', $this->id, $this->getProduct()->getBook(), strtoupper($this->format));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFormat(): ?string
    {
        return $this->format;
    }

    public function setFormat(string $format): self
    {
        $this->format = $format;

        return $this;
    }

    public function getFileUrl(): ?string
    {
        return $this->fileUrl;
    }

    public function setFileUrl(string $fileUrl): self
    {
        $this->fileUrl = $fileUrl;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }
}
