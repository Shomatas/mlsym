<?php

namespace App\Tests\Controller\DataProvider;

use App\Executor\Controller\User\DTO\PatchAddressRequestDto;
use App\Executor\Controller\User\DTO\PatchProfileRequestDto;
use App\Executor\Controller\User\DTO\PatchUserRequestDto;
use Symfony\Component\Uid\Uuid;

trait UsersControllerTestDataProviderTrait
{
    public static function registerDP(): array
    {
        $size = filesize(__DIR__ . "/resources/testfile");

        return [
            [
                [
                    "login" => "paff",
                    "password" => "1234",
                    "profile" => [
                        "firstname" => "Ilya",
                        "lastname" => "Pomazenkov",
                        "age" => "21",
                    ],
                    "address" => [
                        "country" => "Russia",
                        "city" => "Zhizdra",
                        "street" => "Pushkina",
                        "house_number" => "1211",
                    ],
                    "email" => "qpie@mail.ru",
                    "phone" => "+7(937)-531-23-43",
                ],
                [
                    "avatar" => [
                        "name" => "test.jpg",
                        "full_path" =>  __DIR__ . "/resources",
                        "type" => "image/jpeg",
                        "tmp_name" => dirname(__DIR__) . "/resources/testfile",
                        "error" => 0,
                        "size" => $size,
                    ]
                ]
            ]
        ];
    }

    public static function patchUserByIdDataProvider(): array
    {
        return [
            "When login is changed" => [
                Uuid::fromString('da57f603-187e-4de9-8a4b-dfe2d8a34dac'),
                new PatchUserRequestDto('shomatas'),
            ],
            'When password is changed' => [
                Uuid::fromString('e4a7b6c1-6b2b-4736-9431-0bd21a906886'),
                new PatchUserRequestDto(password: '4321'),
            ],
            'When profile is changed' => [
                Uuid::fromString('36e52288-d051-4efb-8b10-d6521d19fa2a'),
                new PatchUserRequestDto(
                    patchProfileRequestDto: new PatchProfileRequestDto('Alexander', 'Shestitka', 22)
                ),
            ],
            'When address is changed' => [
                Uuid::fromString('7cc6e5b3-4987-4770-b73a-a2079874ce29'),
                new PatchUserRequestDto(
                    patchAddressRequestDto: new PatchAddressRequestDto(
                        'Germany',
                        'Hamburg',
                        'Polinova',
                        '23a',
                    )
                )
            ],
            'When email is changed' => [
                Uuid::fromString('28a561d4-170f-41d1-902e-f711891614f5'),
                new PatchUserRequestDto(
                    email: 'shestitka@mail.ru',
                )
            ],
            'When phone is changed' => [
                Uuid::fromString('cf005944-3d80-4c1f-ac89-0b500f50ea30'),
                new PatchUserRequestDto(
                    phone: '8(912)543-13-14',
                )
            ],
        ];
    }
}