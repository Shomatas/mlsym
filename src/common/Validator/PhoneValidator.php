<?php

namespace App\common\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class PhoneValidator extends ConstraintValidator
{

    /**
     * @inheritDoc
     */
    public function validate(mixed $value, Constraint $constraint)
    {
        if (!$constraint instanceof Phone) {
            throw new UnexpectedTypeException($constraint, Phone::class);
        }

        if (is_null($value) or $value === "") {
            return;
        }

        if (preg_match("/^[\+]?\d[\s|\-]?[(]?\d{3}[\)]?[\s|\-]?\d{3}[\s|\-]?\d{2}[\s|\-]?\d{2}$/", $value)) {
            return;
        }

        $this->context->buildViolation('{{ phone }} - некорректный номер телефона')
            ->setParameter('{{ phone }}', $value)
            ->addViolation();
    }
}