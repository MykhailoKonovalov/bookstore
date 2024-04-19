<?php

namespace App\Validation\PublishedCompilationsLimit;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute] class CompilationsLimit extends Constraint
{
    public int $limit;

    public string $message = 'The maximum number of published book compilations ({{ limit }}) has been reached.';

    public function __construct(
        int $limit,
        ?string $message = null,
        mixed $options = null,
        ?array $groups = null,
        mixed $payload = null
    ) {
        $this->limit = $limit;
        $this->message = $message ?? $this->message;;

        parent::__construct($options, $groups, $payload);
    }

    public function validatedBy(): string
    {
        return static::class . 'Validator';
    }

    public function getTargets(): array|string
    {
        return self::CLASS_CONSTRAINT;
    }
}