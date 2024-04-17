<?php

namespace App\Constant;

use App\Constant\Trait\EnumToArrayTrait;

enum BookTypes: string
{
    use EnumToArrayTrait;

    case PAPER = 'paper';

    case ELECTRONIC = 'electronic';
}