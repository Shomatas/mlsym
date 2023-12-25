<?php

namespace App\Tests\Domain\User;

use App\Domain\Address\Factory\AddressFactory;
use App\Domain\User\Exception\UserValidationException;
use App\Domain\User\Factory\DTO\CreateUserDto;
use App\Domain\User\Factory\UserFactory;
use App\Domain\User\User;
use App\Tests\Domain\User\DataProvider\UserFactoryFunctionalDataProviderTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserFactoryFunctionalTest extends KernelTestCase
{
    use UserFactoryFunctionalDataProviderTrait;
    /**
     * @test
     * @dataProvider createDataProvider
     */
    public function create(CreateUserDto $createUserDto): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $userFactory = $container->get(UserFactory::class);
        $user = $userFactory->create($createUserDto);

        self::assertInstanceOf(User::class, $user);
    }



    /**
     * @test
     * @dataProvider createNegativeDataProvider
     */
    public function negativeCreate(CreateUserDto $createUserDto): void
    {
        self::expectException(UserValidationException::class);
        self::bootKernel();
        $container = static::getContainer();

        $userFactory = $container->get(UserFactory::class);
        $userFactory->create($createUserDto);
    }
}