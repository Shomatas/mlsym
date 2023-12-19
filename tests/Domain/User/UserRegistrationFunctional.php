<?php

namespace App\Tests\Domain\User;

use App\Domain\User\Factory\DTO\CreateUserDto;
use App\Domain\User\Factory\UserFactory;
use App\Domain\User\Store\DTO\RequestTemporaryUserFilenameDto;
use App\Domain\User\Store\DTO\UserDTO;
use App\Domain\User\Store\DTO\UserRegisterDTO;
use App\Domain\User\Store\GetUserTestInterface;
use App\Domain\User\Store\SaveUserInterface;
use App\Domain\User\UserRegistration;
use App\Tests\Domain\User\DataProvider\UserRegistrationFunctionalDataProviderTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class UserRegistrationFunctional extends KernelTestCase
{
    use UserRegistrationFunctionalDataProviderTrait;

    /**
     * @test
     * @dataProvider registerDP
     */
    public function register(UserRegisterDTO $userRegisterDTO): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $userGetter = $container->get(GetUserTestInterface::class);
        $initialDataSize = $userGetter->getDataSize();

        $userRegistrar = $container->get(UserRegistration::class);

        $userRegistrar->prepareRegistration($userRegisterDTO);

        $requestTemporaryUserDto = RequestTemporaryUserFilenameDto::createFromUserRegisterDto($userRegisterDTO);
        $temporaryFilename = $userGetter->getTemporaryFilename($requestTemporaryUserDto);

        $userRegistrar->register($temporaryFilename);

        $userDto = $userGetter->getLast();

        self::assertInstanceOf(UserDTO::class, $userDto);
        self::assertEquals($initialDataSize + 1, $userGetter->getDataSize());
    }

    /**
     * @test
     */
    public static function getUserFromUserFactory(CreateUserDto $createUserDto): void
    {

    }
}