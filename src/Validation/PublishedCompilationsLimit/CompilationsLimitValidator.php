<?php

namespace App\Validation\PublishedCompilationsLimit;

use App\Repository\CompilationRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CompilationsLimitValidator extends ConstraintValidator
{
    public function __construct(private readonly CompilationRepository $compilationRepository) {}

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        $count = $this->compilationRepository->createQueryBuilder('c')
                            ->select('COUNT(c.id)')
                            ->where('c.published = :published')
                            ->setParameter('published', true)
                            ->getQuery()
                            ->getSingleScalarResult();

        if ($count >= $constraint->limit) {
            $this->context->buildViolation($constraint->message)
                          ->setParameter('{{ limit }}', $constraint->limit)
                          ->addViolation();
        }
    }
}