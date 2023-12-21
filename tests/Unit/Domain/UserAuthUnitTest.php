<?php

namespace App\Tests\Unit\Domain;

use App\Domain\Address\Store\DTO\AddressDto;
use App\Domain\Exception\SystemException;
use App\Domain\User\Exception\UserAuthException;
use App\Domain\User\Store\DTO\ProfileDto;
use App\Domain\User\Store\DTO\UserAuthorizationDto;
use App\Domain\User\Store\DTO\UserDTO;
use App\Domain\User\Store\GetUserInterface;
use App\Domain\User\Store\UserAuthStoreInterface;
use App\Domain\User\UserAuthInspector;
use Doctrine\DBAL\Exception;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Uid\Uuid;

class UserAuthUnitTest extends KernelTestCase
{
    public UserAuthStoreInterface $userAuthStore;
    public GetUserInterface $userGetter;
    public UserAuthorizationDto $userAuthorizationDto;
    public UserDTO $userDtoStub;

    public function setUp(): void
    {
        $this->userAuthStore = $this->createStub(UserAuthStoreInterface::class);
        $this->userGetter = $this->createStub(GetUserInterface::class);
        $this->userAuthorizationDto = new UserAuthorizationDto(
            "paff", 1234,
        );
        $this->userDtoStub = new UserDTO(
            Uuid::v1(),
            "stub",
            "stub",
            new ProfileDto(
                "stub",
                "stub",
                22,
            ),
            new AddressDto(
                "stub",
                "stub",
                "stub",
                "stub",
            ),
            "stub",
        );
    }

    private function createAuthInspector(): UserAuthInspector
    {
        return new UserAuthInspector($this->userAuthStore, $this->userGetter);
    }

    /**
     * @test
     */
    public function auth(): void
    {
        $this->userAuthStore->method('isAuthCompleted')
            ->willReturn(true);
        $this->userGetter->method('getByLogin')
            ->willReturn($this->userDtoStub);
        $userAuthInspector = $this->createAuthInspector();
        $userDto = $userAuthInspector->auth($this->userAuthorizationDto);
        $this->assertInstanceOf(UserDTO::class, $userDto);
    }

    /**
     * @test
     */
    public function authWithFailedIsStoreAuthCompleted(): void
    {
        $this->expectException(SystemException::class);
        $this->userAuthStore->method('isAuthCompleted')
            ->willThrowException(new Exception);
        $userAuthInspector = $this->createAuthInspector();
        $userAuthInspector->auth($this->userAuthorizationDto);
    }

    /**
     * @test
     */
    public function authWithIsStoreAuthCompletedWillReturnFalse(): void
    {
        $this->expectException(UserAuthException::class);
        $this->userAuthStore->method('isAuthCompleted')
            ->willReturn(false);
        $userAuthInspector = $this->createAuthInspector();
        $userAuthInspector->auth($this->userAuthorizationDto);
    }

    /**
     * @test
     */
    public function authWithFailedGetUserByLogin(): void
    {
        $this->expectException(SystemException::class);
        $this->userAuthStore->method('isAuthCompleted')
            ->willReturn(true);
        $this->userGetter->method('getByLogin')
            ->willThrowException(new Exception);
        $userAuthInspector = $this->createAuthInspector();
        $userAuthInspector->auth($this->userAuthorizationDto);
    }
}