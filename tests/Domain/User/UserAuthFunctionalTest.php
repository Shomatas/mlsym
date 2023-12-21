<?php

namespace App\Tests\Domain\User;

use App\Domain\User\Exception\UserAuthException;
use App\Domain\User\Store\DTO\UserAuthorizationDto;
use App\Domain\User\Store\DTO\UserDTO;
use App\Domain\User\UserAuthInspector;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\Container;

class UserAuthFunctionalTest extends KernelTestCase
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

    /**
     * @test
     * @dataProvider failedAuthDataProvider
     */
    public function failedAuth(UserAuthorizationDto $userAuthorizationDto): void
    {
        $this->expectException(UserAuthException::class);
        $userAuthInspector = $this->container->get(UserAuthInspector::class);
        $userAuthInspector->auth($userAuthorizationDto);
    }

    public static function failedAuthDataProvider(): array
    {
        return [
            'When password is invalid' => [
                new UserAuthorizationDto(
                    'paff',
                    '4321',
                ),
            ],
            'When login doens\'t exists' => [
                new UserAuthorizationDto(
                    'notexistinglogin',
                    '4321',
                ),
            ]
        ];
    }
}