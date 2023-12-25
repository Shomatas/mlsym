<?php

namespace App\Tests\Controller;

use App\Domain\User\Store\GetUserTestInterface;
use App\Tests\Controller\DataProvider\UsersControllerTestDataProviderTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UsersControllerTest extends WebTestCase
{
    const TOKEN = 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3MDM1MDA4NDcsImV4cCI6MTcwMzUwNDQ0Nywicm9sZXMiOlsiUk9MRV9VU0VSIl0sImxvZ2luIjoia29tYXJvdiJ9.XwlfjyZS4vVygnFPq_7kAypqKd2obDp48YAfOsUNg4Pq4-3JpT2vMLE9SZn1D7a57DvQBCMk4uhKu30yW6AbYXxq2WUiHonZjcCIe35PoxJ52LNZQjWdt5S322I-hg9f-BpbDCd12W53tOYxkfwfzGQ91_dwPZjfcNKv7ZFawYxxlJkm-FwigbbkUbHHEIWvcdaZjNXSBgOosVP7iq8l8AA3624BijHnkPPq_D4hJH_DQi0-uenKFQU8HTbtNHXh-kQsaoa3HlPsx_foGbFftHrwFA6_Ypwhod_tngdOKjKdt8cjzBj8V37rHCxQurCXIgTBWvXN91cEVK1VPpPD6A';
    use UsersControllerTestDataProviderTrait;
    /**
     * @test
     */
    public function getAllUsers(): void
    {
        $client = static::createClient();

        $container = static::getContainer();
        $userGetter = $container->get(GetUserTestInterface::class);
        $initialDataSize = $userGetter->getDataSize();


        $response = $client->request('GET', '/users', server: ['HTTP_AUTHORIZATION' => self::TOKEN]);

        $this->assertResponseStatusCodeSame(200);
        $this->assertEquals($initialDataSize, $userGetter->getDataSize());
    }

    /**
     * @test
     * @dataProvider registerDP
     */
    public function register(array $params, array $files): void
    {
        $client = static::createClient();

        self::bootKernel();
        $container = static::getContainer();
        $userGetter = $container->get(GetUserTestInterface::class);
        $initialDataSize = $userGetter->getDataSize();

        $crawler = $client->request('POST', "/users/registration", $params, $files);

        $this->assertResponseStatusCodeSame(201);
        $this->assertEquals($initialDataSize + 1, $userGetter->getDataSize());
    }

}