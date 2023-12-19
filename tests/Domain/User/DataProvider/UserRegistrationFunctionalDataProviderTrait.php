<?php

namespace App\Tests\Domain\User\DataProvider;

use App\Domain\Address\Factory\CreateAddressDto;
use App\Domain\User\Factory\DTO\CreateProfileDto;
use App\Domain\User\Factory\DTO\CreateUserDto;
use App\Domain\User\Store\DTO\AddressRegisterDto;
use App\Domain\User\Store\DTO\ProfileRegisterDto;
use App\Domain\User\Store\DTO\UserRegisterDTO;

trait UserRegistrationFunctionalDataProviderTrait
{
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
                    __DIR__ . "/../../../Controller/resources/testfile",
                    "image/png",
                )
            ]
        ];
    }

    public static function getUserFromUserFactory(): array
    {
        return [
            "When CreateUserDto is valid" => [
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
            ]
        ];
    }
}