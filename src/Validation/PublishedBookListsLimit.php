<?php

namespace App\Validation;

use Symfony\Component\Validator\Constraint;

class PublishedBookListsLimit extends Constraint
{
    public string $message = 'The maximum number of published book lists ({{ limit }}) has been reached.';
    public int $limit;

    public function getTargets(): array|string
    {
        return self::CLASS_CONSTRAINT;
    }
}