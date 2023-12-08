<?php

namespace App\common\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class Integer extends Constraint
{
    public function __construct(mixed $options = null, array $groups = null, mixed $payload = null)
    {
        parent::__construct($options, $groups, $payload);
    }

    public function validatedBy()
    {
        return parent::validatedBy();
    }
}