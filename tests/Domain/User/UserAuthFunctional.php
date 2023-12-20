<?php

namespace App\Tests\Domain\User;

use App\Domain\User\Store\DTO\UserAuthorizationDto;
use App\Domain\User\Store\DTO\UserDTO;
use App\Domain\User\UserAuthInspector;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\Container;

class UserAuthFunctional extends KernelTestCase
{
    public Container $container;
    public function setUp(): void
    {
        self::bootKernel();
        $this->container = static::getContainer();
    }

    /**
     * @test
     * @dataProvider authDataProvider
     */
    public function auth(UserAuthorizationDto $userAuthorizationDto): void
    {
        $userAuthInspector = $this->container->get(UserAuthInspector::class);
        $userDto = $userAuthInspector->auth($userAuthorizationDto);
        $this->assertInstanceOf(UserDTO::class, $userDto);
    }

    public static function authDataProvider(): array
    {
        return [
            "When data is valid" => [
                new UserAuthorizationDto(
                    "paff",
                    "1234",
                )
            ]
        ];
    }

    // TODO: Написать другие тесты
}