<?php

declare(strict_types=1);

namespace App\Validator\ExistEntityConstraint;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;

class ExistEntityValidator extends ConstraintValidator
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function validate($value, Constraint $constraint) : void
    {
        /** @var ExistEntity $constraint */

        if (! $constraint->class) {
            throw new ConstraintDefinitionException(
                'Не установлено значение параметра класс class в аннотации ExistEntity'
            );
        }

        if (! $constraint->attribute) {
            throw new ConstraintDefinitionException(
                'Не установлено значение свойства attribute в аннотации ExistEntity'
            );
        }

        $existingEntity = $this->entityManager
            ->getRepository($constraint->class)
            ->findOneBy([$constraint->attribute => $value]);

        if ($existingEntity) {
            return;
        }

        if ($constraint->allowNull) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->addViolation();
    }
}
