<?php

namespace App\Service\Common;

class DTOValuesService
{
    public static function formatPriceValue(?int $price = 0): ?string
    {
        if ($price) {
            return number_format($price / 100, 2, '.', ' ');
        }

        return null;
    }
}