<?php

namespace App\Constant\Trait;

use ReflectionClass;

trait EnumToArrayTrait
{
    public static function toArray(): array
    {
        $reflectionClass = new ReflectionClass(static::class);
        $constants = $reflectionClass->getConstants();
        $enumArray = [];

        foreach ($constants as $key => $value) {
            $enumArray[$key] = $value;
        }

        return $enumArray;
    }
}