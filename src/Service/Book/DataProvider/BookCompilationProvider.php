<?php

namespace App\Service\Book\DataProvider;

use App\Repository\CompilationRepository;
use App\Service\Book\DTOBuilder\BookCompilationBuilder;

readonly class BookCompilationProvider
{
    public function __construct(
        private CompilationRepository $compilationRepository,
        private BookCompilationBuilder $bookCompilationBuilder,
    ) {}

    public function getBookCompilations(): iterable
    {
        $compilations = $this->compilationRepository->findBy(
            [
                'published' => true,
            ], ['priority' => 'ASC'], 10);

        foreach ($compilations as $compilation) {
            if ($compilation = $this->bookCompilationBuilder->build($compilation)) {
                yield $compilation;
            }
        }
    }
}