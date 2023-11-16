<?php

namespace App\Tests\Domain\User;

class UserRegistrationFunctional extends \PHPUnit\Framework\TestCase
{

    /**
     * @test
     * @dataProvider registerDP
     */
    public function register(string $login, string $password): void
    {
        $db = \App\Store\Connection\Db::getInstance();

        $userSaver = new \App\Store\User\SaveUser();
        $userRegistrar = new \App\Domain\User\UserRegistration($userSaver);
        $user = new \App\Domain\User\User($login, $password);

        $lastId = $userRegistrar->register($user);

        $getUser = new \App\Store\User\GetUser();
        $userDto = $getUser->get($lastId);

        self::assertInstanceOf(\App\Domain\User\Store\DTO\UserDTO::class, $userDto);
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