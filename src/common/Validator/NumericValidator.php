<?php

namespace App\common\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class NumericValidator extends ConstraintValidator
{

    /**
     * @inheritDoc
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof Numeric) {
            throw new UnexpectedTypeException($constraint, Numeric::class);
        }

        if (is_null($value) or $value === '') {
            return;
        }

        if (is_numeric($value)) {
            return;
        }

        $this->context->buildViolation("The value you selected is not a valid choice.")->addViolation();
    }
}