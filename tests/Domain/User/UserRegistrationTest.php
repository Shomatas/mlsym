<?php

namespace App\Tests\Domain\User;

class UserRegistrationTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function register(): void
    {
        $userSaverMock = $this->createMock(\App\Domain\User\Store\SaveUserInterface::class);
        $userSaverMock->expects($this->once())->method('save');
        $userRegister = new \App\Domain\User\UserRegistration($userSaverMock);
//        $userRegister->register(new \App\Domain\User\User("komarov", "4321"));
    }
}