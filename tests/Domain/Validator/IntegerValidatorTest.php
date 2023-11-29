<?php

namespace App\Tests\Domain\Validator;

use App\common\Validator\Integer;
use App\common\Validator\IntegerValidator;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class IntegerValidatorTest extends ConstraintValidatorTestCase
{

    /**
     * @inheritDoc
     */
    protected function createValidator(): ConstraintValidatorInterface
    {
        return new IntegerValidator();
    }

    /**
     * @test
     */
    public function validData(): void
    {
        $this->validator->validate("123", new Integer());

        $this->assertNoViolation();
    }
}