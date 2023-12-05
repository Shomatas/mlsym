<?php

namespace App\Tests\Domain\User\DataProvider;

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
                    __DIR__ . "/../../Controller/resources/testfile",
                    "image/png",
                )
            ]
        ];
    }
}