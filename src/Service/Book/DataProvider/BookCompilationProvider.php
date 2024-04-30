<?php

namespace App\Service\Book\DataProvider;

use App\DTO\BookCompilationDTO;
use App\Entity\Compilation;
use App\Repository\CompilationRepository;
use App\Service\Book\DTOBuilder\BookCompilationBuilder;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;

readonly class BookCompilationProvider
{
    public function __construct(
        private CacheItemPoolInterface $cacheItemPool,
        private CompilationRepository $compilationRepository,
        private BookCompilationBuilder $bookCompilationBuilder,
    ) {}

    /**
     * @return BookCompilationDTO[]
     *
     * @throws InvalidArgumentException
     */
    public function getBookCompilations(): array
    {
        $cachedCompilations = $this->cacheItemPool->getItem(Compilation::CACHE_KEY);

        if (!$cachedCompilations->isHit()) {
            $compilations = iterator_to_array($this->fetchCompilationFromDB());

            $this->cacheItemPool->save(
                $cachedCompilations->set($compilations)->expiresAfter(86400)
            );
        }

        return $cachedCompilations->get();
    }

    private function fetchCompilationFromDB(): iterable
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