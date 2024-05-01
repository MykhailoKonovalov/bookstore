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
        private readonly RequestStack $requestStack
    ) {}

    public function getFunctions(): array
    {
        return [
            new TwigFunction('replaceWithBootstrapClass', [$this, 'replaceWithBootstrapClass']),
            new TwigFunction('addParameterToCurrentQuery', [$this, 'addParameterToCurrentQuery']),
        ];
    }

    public function replaceWithBootstrapClass(string $status): string
    {
        return match ($status) {
            'error' => 'danger',
            default => $status,
        };
    }

    public function addParameterToCurrentQuery(array $params): string
    {
        $request = $this->requestStack->getCurrentRequest();

        return $this->router->generate(
            $request->attributes->get('_route'),
            array_merge($request->query->all(), $params)
        );
    }
}