<?php

namespace App\Entity;

use App\Constant\EBookFormats;
use App\Repository\EBookFormatRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: EBookFormatRepository::class)]
#[ORM\Table(name: "ebook_formats")]
#[ORM\UniqueConstraint(name: "UNIQ_IDENTIFIER_BOOK_FORMAT", fields: ["format", 'product_uuid'])]
#[UniqueEntity(fields: ["format", 'product'], message: "This format is already exists for this book")]
class EBookFormat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 4, enumType: EBookFormats::class)]
    private EBookFormats $format;

    #[ORM\Column(type: Types::STRING)]
    private string $fileUrl;

    #[ORM\ManyToOne(inversedBy: 'eBookFormats')]
    #[ORM\JoinColumn(name: "product_uuid", referencedColumnName: "uuid", nullable: false, onDelete: "CASCADE")]
    private ?Product $product = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFormat(): ?string
    {
        return $this->format->value;
    }

    public function setFormat(EBookFormats $format): self
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
