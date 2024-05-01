<?php

namespace App\Twig\Extension;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function __construct(
        private readonly RouterInterface $router,
        private readonly RequestStack $requestStack,
    ) {}

    public function getFunctions(): array
    {
        return [
            new TwigFunction('replaceWithBootstrapClass', [$this, 'replaceWithBootstrapClass']),
            new TwigFunction('addFilter', [$this, 'addFilter']),
            new TwigFunction('removeFilter', [$this, 'removeFilter']),
            new TwigFunction('checkFilter', [$this, 'checkFilter']),
        ];
    }

    public function replaceWithBootstrapClass(string $status): string
    {
        return match ($status) {
            'error' => 'danger',
            default => $status,
        };
    }

    public function addFilter(array $params): string
    {
        $request = $this->requestStack->getCurrentRequest();

        return $this->router->generate(
            $request->attributes->get('_route'),
            array_merge($request->query->all(), $params),
        );
    }

    public function removeFilter(array $keys): string
    {
        $request = $this->requestStack->getCurrentRequest();

        $request->query->remove(...$keys);

        return $this->router->generate(
            $request->attributes->get('_route'),
            $request->query->all(),
        );
    }

    public function checkFilter(array $params): bool
    {
        $request         = $this->requestStack->getCurrentRequest();
        $queryParameters = $request->query->all();

        return empty(array_diff($params, $queryParameters));
    }
}