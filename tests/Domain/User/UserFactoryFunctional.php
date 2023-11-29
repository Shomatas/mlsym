<?php

namespace App\Tests\Domain\User;

use App\Domain\Address\Address;
use App\Domain\Address\Factory\AddressFactory;
use App\Domain\Address\Factory\CreateAddressDto;
use App\Domain\User\Avatar;
use App\Domain\User\Exception\UserValidationException;
use App\Domain\User\Factory\DTO\CreateProfileDto;
use App\Domain\User\Factory\DTO\CreateUserDto;
use App\Domain\User\Factory\UserFactory;
use App\Domain\User\Profile;
use App\Domain\User\Store\SaveFileInterface;
use App\Domain\User\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
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

        $userFactory = new UserFactory(
            $container->get(ValidatorInterface::class),
            $container->get(SaveFileInterface::class),
            $container->get(AddressFactory::class),
        );
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
                    new CreateProfileDto(
                        "Ivan",
                        "Komarov",
                        22,
                    ),
                    new CreateAddressDto("Russia", "Kaluga", "Suvorova", "121a"),
                    "vano2001komarov@mail.ru",
                    null,
                    "../../Executor/resources/testfile",
                    "image/jpeg",
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

        $userFactory = new UserFactory(
            $container->get(ValidatorInterface::class),
            $container->get(SaveFileInterface::class),
            $container->get(AddressFactory::class),
        );
        $userFactory->create($createUserDto);
    }

    public static function createNegativeDataProvider(): array
    {

        return [
            [
                new CreateUserDto(
                    "",
                    "1234",
                    new CreateProfileDto(
                        "Ivan",
                        "Komarov",
                        22,
                    ),
                    new CreateAddressDto("Russia", "Kaluga", "Suvorova", "121a"),
                    "vano2001komarov@mail.ru",
                    "80000000000",
                    "../../Executor/resources/testfile",
                    "image/jpeg",
                )
            ],
            [
                new CreateUserDto(
                    "paff",
                    "",
                    new CreateProfileDto(
                        "Ivan",
                        "Komarov",
                        22,
                    ),
                    new CreateAddressDto("Russia", "Kaluga", "Suvorova", "121a"),
                    "vano2001komarov@mail.ru",
                    "80000000000",
                    "../../Executor/resources/testfile",
                    "image/jpeg",
                )
            ],
            [
                new CreateUserDto(
                    "paff",
                    "1234",
                    new CreateProfileDto(
                        "Ivan",
                        "Komarov",
                        22,
                    ),
                    new CreateAddressDto("Russia", "Kaluga", "Suvorova", "121a"),
                    "vano2001komarovmail.ru",
                    "80000000000",
                    "../../Executor/resources/testfile",
                    "image/jpeg",
                )
            ],
            [
                new CreateUserDto(
                    "paff",
                    "1234",
                    new CreateProfileDto(
                        "Ivan",
                        "Komarov",
                        22,
                    ),
                    new CreateAddressDto("Russia", "Kaluga", "Suvorova", "121a"),
                    "",
                    "80000000000",
                    "../../Executor/resources/testfile",
                    "image/jpeg",
                )
            ],
            [
                new CreateUserDto(
                    "paff",
                    "1234",
                    new CreateProfileDto(
                        "",
                        "Komarov",
                        22,
                    ),
                    new CreateAddressDto("Russia", "Kaluga", "Suvorova", "121a"),
                    "vano2001komarov@mail.ru",
                    "80000000000",
                    "../../Executor/resources/testfile",
                    "image/jpeg",
                )
            ],
            [
                new CreateUserDto(
                    "paff",
                    "1234",
                    new CreateProfileDto(
                        "Ivan",
                        "",
                        22,
                    ),
                    new CreateAddressDto("Russia", "Kaluga", "Suvorova", "121a"),
                    "vano2001komarov@mail.ru",
                    "80000000000",
                    "../../Executor/resources/testfile",
                    "image/jpeg",
                )
            ],
            [
                new CreateUserDto(
                    "paff",
                    "1234",
                    new CreateProfileDto(
                        "Ivan",
                        "Komarov",
                        22,
                    ),
                    new CreateAddressDto("Russia", "Kaluga", "Suvorova", "121a"),
                    "vano2001komarov@mail.ru",
                    "893712608",
                    "../../Executor/resources/testfile",
                    "image/jpeg",
                )
            ],
        ];
    }
}