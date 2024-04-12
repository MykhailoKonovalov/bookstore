<?php

namespace App\Entity;

use App\Constant\EBookFormats;
use App\Entity\Interfaces\HasTimestamp;
use App\Entity\Interfaces\ProductInterface;
use App\Entity\Traits\ProductTrait;
use App\Entity\Traits\TimestampTrait;
use App\Repository\EBooksRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EBooksRepository::class)]
#[ORM\Table(name: "ebooks")]
#[ORM\Index(columns: ['format'], name: 'eb_format_idx')]
#[ORM\HasLifecycleCallbacks]
class EBook implements HasTimestamp, ProductInterface
{
    use TimestampTrait;

    use ProductTrait;

    #[ORM\Id]
    #[ORM\OneToOne(inversedBy: 'eBook', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: "book_copy_uuid", referencedColumnName: "uuid", nullable: false)]
    private ?BookCopy $bookCopy = null;

    #[ORM\Column(type: Types::STRING, length: 4, enumType: EBookFormats::class)]
    private EBookFormats $format;

    #[ORM\Column(type: Types::STRING)]
    private string $fileUrl;

    public function getBookCopy(): BookCopy
    {
        return $this->bookCopy;
    }

    public function setBookCopy(BookCopy $bookCopy): self
    {
        $this->bookCopy = $bookCopy;

        return $this;
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
}
