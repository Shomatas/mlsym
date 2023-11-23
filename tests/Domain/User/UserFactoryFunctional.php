<?php

namespace App\Tests\Domain\User;

use App\Domain\Address\Address;
use App\Domain\Address\Factory\AddressFactory;
use App\Domain\Address\Factory\CreateAddressDto;
use App\Domain\Address\Store\DTO\AddressDto;
use App\Domain\User\Avatar;
use App\Domain\User\Exception\UserValidationException;
use App\Domain\User\Factory\CreateUserDto;
use App\Domain\User\Factory\UserFactory;
use App\Domain\User\Profile;
use App\Domain\User\Store\DTO\UserDTO;
use App\Domain\User\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserFactoryFunctional extends KernelTestCase
{
    /**
     * @test
     * @dataProvider createDataProvider
     */
    public function create(CreateUserDto $createUserDto): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $userFactory = new UserFactory($container->get(ValidatorInterface::class));
        $user = $userFactory->create($createUserDto);

        self::assertInstanceOf(User::class, $user);
    }

    public static function createDataProvider(): array
    {

        return [
            [
                new CreateUserDto(
                    "paff",
                    "1234",
                    new Profile(
                        "Ivan",
                        "Komarov",
                        22,
                        new Avatar("20210505175821!NyanCat.gif", 'image/gif')
                    ),
                    new Address("Russia", "Kaluga", "Suvorova", "121a"),
                    "vano2001komarov@mail.ru",
                    "80000000000",
                )
            ],
        ];
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

        $userFactory = new UserFactory($container->get(ValidatorInterface::class));
        $userFactory->create($createUserDto);
    }

    public static function createNegativeDataProvider(): array
    {

        return [
            [
                new CreateUserDto(
                    "",
                    "1234",
                    new Profile(
                        "Ivan",
                        "Komarov",
                        22,
                        new Avatar("20210505175821!NyanCat.gif", 'image/gif')
                    ),
                    new Address("Russia", "Kaluga", "Suvorova", "121a"),
                    "vano2001komarov@mail.ru",
                    "80000000000",
                )
            ],
            [
                new CreateUserDto(
                    "paff",
                    "",
                    new Profile(
                        "Ivan",
                        "Komarov",
                        22,
                        new Avatar("20210505175821!NyanCat.gif", 'image/gif')
                    ),
                    new Address("Russia", "Kaluga", "Suvorova", "121a"),
                    "vano2001komarov@mail.ru",
                    "80000000000",
                )
            ],
            [
                new CreateUserDto(
                    "paff",
                    "1234",
                    new Profile(
                        "Ivan",
                        "Komarov",
                        22,
                        new Avatar("20210505175821!NyanCat.gif", 'image/gif')
                    ),
                    new Address("Russia", "Kaluga", "Suvorova", "121a"),
                    "vano2001komarovmail.ru",
                    "80000000000",
                )
            ],
            [
                new CreateUserDto(
                    "paff",
                    "1234",
                    new Profile(
                        "Ivan",
                        "Komarov",
                        22,
                        new Avatar("20210505175821!NyanCat.gif", 'image/gif')
                    ),
                    new Address("Russia", "Kaluga", "Suvorova", "121a"),
                    "",
                    "80000000000",
                )
            ],
            [
                new CreateUserDto(
                    "paff",
                    "1234",
                    new Profile(
                        "",
                        "Komarov",
                        22,
                        new Avatar("20210505175821!NyanCat.gif", 'image/gif')
                    ),
                    new Address("Russia", "Kaluga", "Suvorova", "121a"),
                    "vano2001komarov@mail.ru",
                    "80000000000",
                )
            ],
            [
                new CreateUserDto(
                    "paff",
                    "1234",
                    new Profile(
                        "Ivan",
                        "",
                        22,
                        new Avatar("20210505175821!NyanCat.gif", 'image/gif')
                    ),
                    new Address("Russia", "Kaluga", "Suvorova", "121a"),
                    "vano2001komarov@mail.ru",
                    "80000000000",
                )
            ],
            [
                new CreateUserDto(
                    "paff",
                    "1234",
                    new Profile(
                        "Ivan",
                        "Komarov",
                        22,
                        new Avatar("", 'image/gif')
                    ),
                    new Address("Russia", "Kaluga", "Suvorova", "121a"),
                    "vano2001komarov@mail.ru",
                    "80000000000",
                )
            ],
            [
                new CreateUserDto(
                    "paff",
                    "1234",
                    new Profile(
                        "Ivan",
                        "Komarov",
                        22,
                        new Avatar("20210505175821!NyanCat.gif", '')
                    ),
                    new Address("Russia", "Kaluga", "Suvorova", "121a"),
                    "vano2001komarov@mail.ru",
                    "80000000000",
                )
            ],
            [
                new CreateUserDto(
                    "paff",
                    "1234",
                    new Profile(
                        "Ivan",
                        "Komarov",
                        22,
                        new Avatar("20210505175821!NyanCat.gif", 'image/bmp')
                    ),
                    new Address("Russia", "Kaluga", "Suvorova", "121a"),
                    "vano2001komarov@mail.ru",
                    "80000000000",
                )
            ],
        ];
    }
}