<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Form;

class UsersControllerTest extends WebTestCase
{
    /**
     * @test
     */
    public function getAllUsers(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/users');

        $this->assertResponseStatusCodeSame(200);
    }

    /**
     * @test
     * @dataProvider registerDP
     */
    public function register(array $params, array $files): void
    {
        $client = static::createClient();


        $crawler = $client->request('POST', "/users/registration", $params, $files);

        $this->assertResponseStatusCodeSame(201);
    }

    public static function registerDP(): array
    {
        $size = filesize(__DIR__ . "/resources/testfile");

        return [
            [
                [
                    "login" => "qpie",
                    "password" => "1234",
                    "profile" => [
                        "firstname" => "Ilya",
                        "lastname" => "Pomazenkov",
                        "age" => 21,
                    ],
                    "address" => [
                        "country" => "Russia",
                        "city" => "Zhizdra",
                        "street" => "Pushkina",
                        "houseNumber" => "1211",
                    ],
                    "email" => "qpie@mail.ru",
                    "phone" => "89375312343",
                ],
                [
                    "avatar" => [
                        "name" => "test.jpg",
                        "full_path" =>  __DIR__ . "/resources",
                        "type" => "image/jpeg",
                        "tmp_name" => __DIR__ . "/resources/testfile",
                        "error" => 0,
                        "size" => $size,
                    ]
                ]
            ]
        ];
    }
}