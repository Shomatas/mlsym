<?php

namespace App\Tests\Domain\User;

use App\Domain\Address\Address;
use App\Domain\User\Avatar;
use App\Domain\User\Factory\UserFactory;
use App\Domain\User\Profile;
use App\Domain\User\Store\DTO\AddressRegisterDto;
use App\Domain\User\Store\DTO\ProfileRegisterDto;
use App\Domain\User\Store\DTO\UserDTO;
use App\Domain\User\Store\DTO\UserRegisterDTO;
use App\Domain\User\Store\GetUserTestInterface;
use App\Domain\User\Store\SaveUserInterface;
use App\Domain\User\UserRegistration;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Uid\Uuid;


class UserRegistrationFunctional extends KernelTestCase
{

    /**
     * @test
     * @dataProvider registerDP
     */
    public function register(UserRegisterDTO $userRegisterDTO): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $userSaver = $container->get(SaveUserInterface::class);
        $userFactory = $container->get(UserFactory::class);
        $userRegistrar = new UserRegistration($userSaver, $userFactory);

        $userRegistrar->register($userRegisterDTO);

        $getUser = $container->get(GetUserTestInterface::class);
        $userDto = $getUser->getLast();

        self::assertInstanceOf(UserDTO::class, $userDto);
    }

    public static function registerDP(): array
    {
        return [
            [
                new UserRegisterDTO(
                    "paff",
                    "1234",
                    new ProfileRegisterDto(
                        "Ivan",
                        "Komarov",
                        22,
                    ),
                    new AddressRegisterDto("Russia", "Kaluga", "Suvorova", "121a"),
                    "vano2001komarov@mail.ru",
                    "89371260827",
                    __DIR__ . "/../../Controller/resources/testfile",
                    "image/png",
                )
            ]
        ];
    }
}