<?php

namespace App\Tests\Domain\User;

use App\Domain\Address\Address;
use App\Domain\User\Avatar;
use App\Domain\User\Profile;
use App\Domain\User\Store\DTO\UserDTO;
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
    public function register(UserDTO $userDTO): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $userSaver = $container->get(SaveUserInterface::class);
        $userRegistrar = new UserRegistration($userSaver);

        $userRegistrar->register($userDTO);

        $getUser = $container->get(GetUserTestInterface::class);
        $userDto = $getUser->get($userDTO->id);

        self::assertInstanceOf(UserDTO::class, $userDto);
    }

    public static function registerDP(): array
    {
        return [
            [new UserDTO(
                Uuid::v1(),
                "paff",
                "1234",
                new Profile(
                    "Ivan",
                    "Komarov",
                    22,
                    new Avatar("images/20210505175821!NyanCat.gif", 'image/gif')
                ),
                new Address("Russia", "Kaluga", "Suvorova", "121a"),
                "vano2001komarov@mail.ru",
                "",
            )]
        ];
    }
}