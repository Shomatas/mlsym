<?php

namespace App\Tests\Domain\Validator;

use App\common\Validator\Phone;
use App\common\Validator\PhoneValidator;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class PhoneValidatorTest extends ConstraintValidatorTestCase
{

    /**
     * @inheritDoc
     */
    protected function createValidator(): ConstraintValidatorInterface
    {
        return new PhoneValidator();
    }

    /**
     * @test
     * @dataProvider validDP
     */
    public function validData(string $value): void
    {
        $this->validator->validate($value, new Phone);

        $this->assertNoViolation();
    }

    public static function validDP(): array
    {
        return [
            ["89371260827"],
            ["+79371260827"],
            ["8 (937) 126 0827"],
            ["+7-(937)-126-08-27"],
        ];
    }

    /**
     * @test
     * @dataProvider invalidDP
     */
    public function invalidData(string $value): void
    {
        $this->validator->validate($value, new Phone);

        $this->buildViolation("The value you selected is phone.")->assertRaised();
    }

    public static function invalidDP(): array
    {
        return [
            ["-89371260827"],
            ["79-371260827"],
            ["8 )937( 126 0827"],
            ["+7-(937)-126-082-7"],
        ];
    }

}