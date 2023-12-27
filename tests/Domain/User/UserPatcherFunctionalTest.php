<?php

namespace App\Tests\Domain\User;

use App\Domain\User\Exception\PatchValidationException;
use App\Domain\User\Store\DTO\PatchUserDto;
use App\Domain\User\Store\GetUserInterface;
use App\Domain\User\UserPatcher;
use App\Tests\Domain\User\DataProvider\UserPatcherFunctionalDataProviderTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserPatcherFunctionalTest extends KernelTestCase
{
    private UserPatcher $userPatcher;
    private GetUserInterface $getUser;
    public function setUp(): void
    {
        self::bootKernel();
        $this->userPatcher = static::getContainer()->get(UserPatcher::class);
        $this->getUser = static::getContainer()->get(GetUserInterface::class);
    }

    use UserPatcherFunctionalDataProviderTrait;

    /**
     * @test
     * @dataProvider patchDataProvider
     */
    public function patch(PatchUserDto $patchUserDto) {
        $initialUserDto = $this->getUser->get($patchUserDto->id);
        $this->userPatcher->patch($patchUserDto);
        $userDto = $this->getUser->get($patchUserDto->id);
        $this->assertNotEquals($initialUserDto, $userDto);
    }

    /**
     * @test
     * @dataProvider failedPatchDataProvider
     */
    public function failedPatch(PatchUserDto $patchUserDto)
    {
        $this->expectException(PatchValidationException::class);
        $this->userPatcher->patch($patchUserDto);
    }
}