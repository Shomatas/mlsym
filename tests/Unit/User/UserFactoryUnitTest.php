<?php

namespace App\Tests\Unit\User;

use App\Domain\Address\Exception\AddressFactoryException;
use App\Domain\Address\Factory\AddressFactory;
use App\Domain\Address\Factory\CreateAddressDto;
use App\Domain\Exception\DomainException;
use App\Domain\User\Factory\DTO\CreateProfileDto;
use App\Domain\User\Factory\DTO\CreateUserDto;
use App\Domain\User\Factory\UserFactory;
use App\Domain\User\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserFactoryUnitTest extends KernelTestCase
{
    private CreateUserDto $createUserDto;

    public function setUp(): void
    {
        $this->createUserDto = new CreateUserDto(
            'paff',
            '1234',
            new CreateProfileDto(
                'ivan',
                'komarov',
                22,
            ),
            new CreateAddressDto(
                'Russia',
                'Kaluga',
                'Suvorova',
                '121a',
            ),
            'vano2001komarov@mail.ru',
            null,
            'stub',
            'stub',
        );
    }

    /**
     * @test
     */
    public function create(): void
    {
        $validator = $this->createStub(ValidatorInterface::class);
        $addressFactory = $this->createStub(AddressFactory::class);
        $createUserFactory = new UserFactory(
            $validator,
            $addressFactory
        );
        $user = $createUserFactory->create($this->createUserDto);
        $this->assertInstanceOf(User::class, $user);
    }

    /**
     * @test
     */
    public function failedValidation(): void
    {
        $this->expectException(DomainException::class);
        $constraintViolation = $this->createStub(ConstraintViolationListInterface::class);
        $constraintViolation->method('count')
            ->willReturn(1);
        $validator = $this->createStub(ValidatorInterface::class);
        $validator->method('validate')
            ->willReturn($constraintViolation);
        $addressFactory = $this->createStub(AddressFactory::class);
        $createUserFactory = new UserFactory(
            $validator,
            $addressFactory
        );
        $createUserFactory->create($this->createUserDto);
    }

    /**
     * @test
     */
    public function failedAddressFactoryCreate(): void
    {
        $this->expectException(DomainException::class);
        $validator = $this->createStub(ValidatorInterface::class);
        $addressFactory = $this->createStub(AddressFactory::class);
        $addressFactory->method('create')->willThrowException(new AddressFactoryException);
        $userFactory = new UserFactory(
            $validator,
            $addressFactory,
        );
        $userFactory->create($this->createUserDto);
    }

    /**
     * @test
     */
    public function countCalledMethods(): void
    {
        $validator = $this->createMock(ValidatorInterface::class);
        $validator->expects(self::exactly(3))
            ->method('validate');
        $addressFactory = $this->createMock(AddressFactory::class);
        $addressFactory->expects(self::once())
            ->method('create');
        $userFactory = new UserFactory(
            $validator,
            $addressFactory,
        );
        $userFactory->create($this->createUserDto);
    }
}