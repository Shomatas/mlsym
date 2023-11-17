<?php

namespace App\Tests\Domain\User;

use App\Domain\User\Store\DTO\UserDTO;
use App\Domain\User\Store\GetUserTestInterface;
use App\Domain\User\Store\SaveUserInterface;
use App\Domain\User\UserRegistration;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class UserRegistrationFunctional extends KernelTestCase
{

    /**
     * @test
     * @dataProvider registerDP
     */
    public function register(string $login, string $password): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $userSaver = $container->get(SaveUserInterface::class);
        $userRegistrar = new UserRegistration($userSaver);
        $user = new UserDTO(0, $login, $password);

        $lastId = $userRegistrar->register($user);

        $getUser = $container->get(GetUserTestInterface::class);
        $userDto = $getUser->get($lastId);

        self::assertInstanceOf(UserDTO::class, $userDto);
    }

    public static function registerDP(): array
    {
        return [
            [
                "paff", "1234"
            ]
        ];
    }
}