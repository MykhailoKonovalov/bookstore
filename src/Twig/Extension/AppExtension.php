<?php

namespace App\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('replaceWithBootstrapClass', [$this, 'replaceWithBootstrapClass']),
        ];
    }

    public function replaceWithBootstrapClass(string $status): string
    {
        return match ($status) {
            'error' => 'danger',
            default => $status,
        };
    }
}