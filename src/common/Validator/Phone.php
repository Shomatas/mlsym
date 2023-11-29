<?php

namespace App\common\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class Phone extends Constraint
{
    public function __construct(mixed $options = null, array $groups = null, mixed $payload = null)
    {
        parent::__construct($options, $groups, $payload);
    }
}