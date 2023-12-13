<?php

namespace App\Tests\Domain\User\DataProvider;

use App\Domain\Address\Factory\CreateAddressDto;
use App\Domain\User\Factory\DTO\CreateProfileDto;
use App\Domain\User\Factory\DTO\CreateUserDto;

trait UserFactoryFunctionalDataProviderTrait
{
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