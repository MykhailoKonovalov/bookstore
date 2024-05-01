<?php

namespace App\Service\Book\DTOBuilder;

use App\DTO\BookCompilationDTO;
use App\Entity\Compilation;

readonly class BookCompilationBuilder
{
    public function build(Compilation $compilation): ?BookCompilationDTO
    {
        if (0 === $compilation->getBooks()->count()) {
            return null;
        }

        return new BookCompilationDTO(
            $compilation->getTitle(),
            $compilation->getStickerColor(),
            iterator_to_array(
                $this->buildBookPreviewList(
                    $compilation->getBooks()->toArray()
                )
            ),
        );
    }

    private function buildBookPreviewList(array $books): iterable
    {
        foreach ($books as $book) {
            yield BookPreviewBuilder::build($book);
        }
    }
}