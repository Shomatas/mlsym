<?php

namespace App\Tests\Domain\Validator;

use App\common\Validator\Numeric;
use App\common\Validator\NumericValidator;
use App\Tests\Domain\Validator\DataProvider\NumericValidatorTestDataProviderTrait;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class NumericValidatorTest extends ConstraintValidatorTestCase
{
    use NumericValidatorTestDataProviderTrait;

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

    /**
     * @test
     * @dataProvider invalidDP
     */
    public function invalidData(mixed $value): void
    {
        $this->validator->validate($value, new Numeric());

        $this->buildViolation("The value you selected is not a valid choice.")->assertRaised();
    }

}