<?php

namespace App\Tests\Unit\Address;

use App\Domain\Address\Address;
use App\Domain\Address\Factory\AddressFactory;
use App\Domain\Address\Factory\CreateAddressDto;
use App\Domain\Exception\DomainException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddressFactoryUnitTest extends KernelTestCase
{
    private CreateAddressDto $createAddressDto;
    public function setUp(): void
    {
        $this->createAddressDto = new CreateAddressDto(
            "Russia",
            "Kaluga",
            "Suvorova",
            "121a",
        );
    }

    /**
     * @test
     */
    public function create(): void
    {
        $validator = $this->createStub(ValidatorInterface::class);
        $addressFactory = new AddressFactory($validator);
        $address = $addressFactory->create($this->createAddressDto);
        $this->assertInstanceOf(Address::class, $address);
    }

    /**
     * @test
     */
    public function failedValidation(): void
    {
        $this->expectException(DomainException::class);
        $constraintViolationListInterface = $this->createStub(ConstraintViolationListInterface::class);
        $constraintViolationListInterface->method('count')
            ->willReturn(1);
        $validator = $this->createStub(ValidatorInterface::class);
        $validator->method('validate')
            ->willReturn($constraintViolationListInterface);
        $addressFactory = new AddressFactory($validator);
        $addressFactory->create($this->createAddressDto);
    }

    /**
     * @test
     */
    public function countCalledMethods(): void
    {
        $validator = $this->createMock(ValidatorInterface::class);
        $validator->expects(self::once())
            ->method('validate');
        $addressFactory = new AddressFactory(
            $validator,
        );
        $addressFactory->create($this->createAddressDto);
    }
}