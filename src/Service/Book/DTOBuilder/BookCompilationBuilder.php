<?php

namespace App\Service\Book\DTOBuilder;

use App\DTO\BookCompilationDTO;
use App\Entity\Compilation;

readonly class BookCompilationBuilder
{
    public function __construct(private BookPreviewBuilder $bookPreviewBuilder) {}

    public function build(Compilation $compilation): BookCompilationDTO
    {
        $bookPreviewList = [];

        foreach ($compilation->getBooks() as $book) {
            $bookPreviewList[] = $this->bookPreviewBuilder->build($book);
        }

        return new BookCompilationDTO(
            $compilation->getTitle(),
            $bookPreviewList,
        );
    }
}