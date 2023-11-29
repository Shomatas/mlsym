<?php

namespace App\Tests\Domain\Validator;

use App\common\Validator\Numeric;
use App\common\Validator\NumericValidator;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class NumericValidatorTest extends ConstraintValidatorTestCase
{

    /**
     * @inheritDoc
     */
    protected function createValidator(): ConstraintValidatorInterface
    {
        return new NumericValidator();
    }

    /**
     * @test
     * @dataProvider validDP
     */
    public function validData($value): void
    {
        $this->validator->validate($value, new Numeric());

        $this->assertNoViolation();
    }

    public static function validDP(): array
    {
        return [
            ["123"],
            [123],
            [123.23],
            ["123.32"],
            ["12e3"]
        ];
    }

    /**
     * @test
     * @dataProvider invalidDP
     */
    public function invalidData(mixed $value): void
    {
        $this->validator->validate($value, new Numeric());

        $this->buildViolation("The value you selected is not a valid choice.")->assertRaised();
    }

    public static function invalidDP(): array
    {
        return [
            ["123a"],
            ["a123"],
            ["abacaba"],
            ["?.dsf23"],
            ["a123a"],
        ];
    }
}