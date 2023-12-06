<?php

namespace App\Tests\Domain\Validator;

use App\common\Validator\Phone;
use App\common\Validator\PhoneValidator;
use App\Tests\Domain\Validator\DataProvider\PhoneValidatorTestDataProviderTrait;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class PhoneValidatorTest extends ConstraintValidatorTestCase
{

    use PhoneValidatorTestDataProviderTrait;
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


    /**
     * @test
     * @dataProvider invalidDP
     */
    public function invalidData(string $value): void
    {
        $this->validator->validate($value, new Phone);

        $this->buildViolation('{{ phone }} - некорректный номер телефона')->setParameter("{{ phone }}", $value)->assertRaised();
    }


}