<?php

namespace App\Tests\Controller;

use App\Domain\User\Store\GetUserTestInterface;
use App\Tests\Controller\DataProvider\UsersControllerTestDataProviderTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UsersControllerTest extends WebTestCase
{
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

        $response = $client->request('GET', '/users');

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

        $crawler = $client->request('POST', '/users/registration', $params, $files);

        $this->assertResponseStatusCodeSame(201);
        $this->assertEquals($initialDataSize + 1, $userGetter->getDataSize());
    }

    /**
     * @test
     */
    public function getUserById(): void
    {
        $client = static::createClient();
        self::bootKernel();
        $container = static::getContainer();
        $userGetter = $container->get(GetUserTestInterface::class);
        $userDto = $userGetter->getLast();
        $initialDataSize = $userGetter->getDataSize();

        $crawler = $client->request('GET', "/users/{$userDto->id}");

        $this->assertResponseStatusCodeSame(200);
        $this->assertEquals($initialDataSize, $userGetter->getDataSize());
    }
}