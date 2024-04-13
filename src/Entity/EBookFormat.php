<?php

namespace App\Entity;

use App\Constant\EBookFormats;
use App\Repository\EBookFormatRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: EBookFormatRepository::class)]
#[ORM\Table(name: "ebook_formats")]
#[ORM\UniqueConstraint(name: "UNIQ_IDENTIFIER_BOOK_FORMAT", fields: ["format", "eBook"])]
#[UniqueEntity(fields: ["eBook", "format"], message: "This format is already exists for this book")]
#[ORM\Index(columns: ["eBook", "format"], name: "ebook_format_idx")]
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
    #[ORM\JoinColumn(name: "ebook_uuid", referencedColumnName: "uuid", nullable: false)]
    #[ORM\Column(name: 'eBook')]
    private ?EBook $eBook = null;

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

    public function getEbook(): ?EBook
    {
        return $this->eBook;
    }

    public function setEbook(?EBook $ebook): self
    {
        $this->eBook = $ebook;

        return $this;
    }
}
