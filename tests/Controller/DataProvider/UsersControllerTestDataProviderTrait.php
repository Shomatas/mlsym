<?php

namespace App\Tests\Controller\DataProvider;

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
                        "houseNumber" => "1211",
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
}