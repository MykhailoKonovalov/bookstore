<?php

namespace App\Service\Book\DataProvider;

use App\DTO\BookCompilationDTO;
use App\Repository\CompilationRepository;
use App\Service\Book\DTOBuilder\BookCompilationBuilder;

readonly class BookCompilationProvider
{
    public function __construct(
        private CompilationRepository $compilationRepository,
        private BookCompilationBuilder $bookCompilationBuilder,
    ) {}

    /**
     * @return BookCompilationDTO[]
     */
    public function getBookCompilations(): array
    {
        $compilations    = $this->compilationRepository->findBy(
            [
                'published' => true,
            ], ['priority' => 'ASC'], 10);
        $compilationDTOs = [];

        foreach ($compilations as $compilation) {
            $compilationDTOs[] = $this->bookCompilationBuilder->build($compilation);
        }

        return $compilationDTOs;
    }
}