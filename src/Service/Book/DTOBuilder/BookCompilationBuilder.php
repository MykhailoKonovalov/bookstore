<?php

namespace App\Service\Book\DTOBuilder;

use App\DTO\BookCompilationDTO;
use App\Entity\Compilation;
use App\Service\Book\DataProvider\BookListProvider;
use Doctrine\Common\Collections\Collection;

readonly class BookCompilationBuilder
{
    public function __construct(
        private BookListProvider $bookListProvider,
    ) {}

    public function build(Compilation $compilation): ?BookCompilationDTO
    {
        if (0 === $compilation->getBooks()->count()) {
            return null;
        }

        return new BookCompilationDTO(
            $compilation->getTitle(),
            $compilation->getStickerColor(),
            iterator_to_array(
                $this->bookListProvider->buildBookPreviewList(
                    $compilation->getBooks()->toArray()
                )
            ),
        );
    }


}