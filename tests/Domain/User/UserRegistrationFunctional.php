<?php

namespace App\Tests\Domain\User;

use App\Domain\User\Store\DTO\UserDTO;
use App\Domain\User\Store\SaveUserInterface;
use App\Domain\User\User;
use App\Domain\User\UserRegistration;
use App\Store\Connection\Db;
use App\Store\User\GetUser;
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
        $db = Db::getInstance();

        $userSaver = $container->get(SaveUserInterface::class);
        $userRegistrar = new UserRegistration($userSaver);
        $user = new User($login, $password);

        $lastId = $userRegistrar->register($user);

        $getUser = new GetUser();
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