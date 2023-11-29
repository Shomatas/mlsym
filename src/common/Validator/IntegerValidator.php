<?php

namespace App\common\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class IntegerValidator extends ConstraintValidator
{

    /**
     * @inheritDoc
     */
    public function validate(mixed $value, Constraint $constraint)
    {
        if (!$constraint instanceof Integer) {
            throw new UnexpectedTypeException($constraint, Numeric::class);
        }

        if (is_null($value) or $value === '') {
            return;
        }

        if (is_int($value)) {
            return;
        }

        if (is_string($value) && preg_match("/^[0-9]+$/", $value)) {
            return;
        }

        $this->context->buildViolation("The value you selected is not a integer.")->addViolation();
    }
}