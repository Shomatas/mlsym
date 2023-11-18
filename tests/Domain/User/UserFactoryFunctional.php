<?php

namespace App\Tests\Domain\User;

use App\Domain\Address\Address;
use App\Domain\Address\Factory\AddressFactory;
use App\Domain\Address\Factory\CreateAddressDto;
use App\Domain\Address\Store\DTO\AddressDto;
use App\Domain\User\Exception\UserValidationException;
use App\Domain\User\Factory\CreateUserDto;
use App\Domain\User\Factory\UserFactory;
use App\Domain\User\Profile;
use App\Domain\User\Store\DTO\UserDTO;
use App\Domain\User\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserFactoryFunctional extends KernelTestCase
{
    /**
     * @test
     * @dataProvider createDataProvider
     */
    public function create(UserDTO $userDto): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $createUserDto = new CreateUserDto($userDto);

        $userFactory = new UserFactory($container->get(ValidatorInterface::class));
        $user = $userFactory->create($createUserDto);

        self::assertInstanceOf(User::class, $user);
    }

    public static function createDataProvider(): array
    {

        return [
            [new UserDTO(
                address: self::getAddress("Russia", "Kaluga", "Suvorova", "121a"),
                profile: new Profile("Ivan", "Komarov", 22),
                login: "paff",
                password: "1234",
                email: "vano2001komarov@mail.ru",
                phone: "",
            )]
        ];
    }

    /**
     * @test
     * @dataProvider createNegativeDataProvider
     */
    public function negativeCreate($userDto): void
    {
        self::expectException(UserValidationException::class);
        self::bootKernel();
        $container = static::getContainer();
        $createUserDto = new CreateUserDto($userDto);

        $userFactory = new UserFactory($container->get(ValidatorInterface::class));
        $userFactory->create($createUserDto);
    }

    public static function createNegativeDataProvider(): array
    {

        return [
            [new UserDTO(
                address: self::getAddress("Russia", "Kaluga", "Suvorova", "121a"),
                profile: new Profile("Ivan", "Komarov", 22),
                login: "",
                password: "1234",
                email: "vano2001komarov@mail.ru",
                phone: "8111111111",
            )],

            [new UserDTO(
                address: self::getAddress("Russia", "Kaluga", "Suvorova", "121a"),
                profile: new Profile("Ivan", "Komarov", 22),
                login: "paff",
                password: "1234",
                email: "vano2001komarovmail.ru",
                phone: "8111111111",
            )]
        ];
    }

    private static function getAddress(
        string $country,
        string $city,
        string $street,
        string $houseNumber
    ): Address
    {
        self::bootKernel();
        $container = static::getContainer();
        $validator = $container->get(ValidatorInterface::class);
        $addressFactory = new AddressFactory($validator);
        $addressDto = new AddressDto($country, $city, $street, $houseNumber);
        $createAddressDto = new CreateAddressDto($addressDto);
        return $addressFactory->create($createAddressDto);
    }
}