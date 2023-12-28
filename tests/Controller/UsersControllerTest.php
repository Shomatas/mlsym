<?php

namespace App\Tests\Controller;

use App\Domain\User\Store\GetUserInterface;
use App\Domain\User\Store\GetUserTestInterface;
use App\Executor\Controller\User\DTO\PatchUserRequestDto;
use App\Tests\Controller\DataProvider\UsersControllerTestDataProviderTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Uid\Uuid;

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

    /**
     * @test
     * @dataProvider patchUserByIdDataProvider
     */
    public function patchUserById(Uuid $id,  PatchUserRequestDto $patchUserRequestDto): void
    {
        $client = static::createClient();
        self::bootKernel();
        $container = static::getContainer();
        $userGetter = $container->get(GetUserInterface::class);
        $initialUserDto = $userGetter->get($id);
        $client->request('PATCH', "/users/{$id}", [
            'login' => $patchUserRequestDto->login,
            'password' => $patchUserRequestDto->password,
            'profile[firstname]' => $patchUserRequestDto->patchProfileRequestDto?->firstname,
            'profile[lastname]' => $patchUserRequestDto->patchProfileRequestDto?->lastname,
            'profile[age]' => $patchUserRequestDto->patchProfileRequestDto?->age,
            'address[country]' => $patchUserRequestDto->patchAddressRequestDto?->country,
            'address[city]' => $patchUserRequestDto->patchAddressRequestDto?->city,
            'address[street]' => $patchUserRequestDto->patchAddressRequestDto?->street,
            'address[house_number]' => $patchUserRequestDto->patchAddressRequestDto?->houseNumber,
            'email' => $patchUserRequestDto->email,
            'phone' => $patchUserRequestDto->phone,
        ]);
        $userDto = $userGetter->get($id);
        $this->assertNotEquals($initialUserDto, $userDto);
    }
}