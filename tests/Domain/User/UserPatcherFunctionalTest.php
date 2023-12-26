<?php

namespace App\Tests\Domain\User;

use App\Domain\User\Store\DTO\PatchUserDto;
use App\Domain\User\UserPatcher;
use App\Tests\Domain\User\DataProvider\UserPatcherFunctionalDataProviderTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserPatcherFunctionalTest extends KernelTestCase
{
    private UserPatcher $userPatcher;
    public function setUp(): void
    {
        self::bootKernel();
        $this->userPatcher = static::getContainer()->get(UserPatcher::class);
    }

    use UserPatcherFunctionalDataProviderTrait;

    /**
     * @test
     * @dataProvider patchDataProvider
     */
    public function patch(PatchUserDto $patchUserDto) {
        $this->expectNotToPerformAssertions();
        $this->userPatcher->patch($patchUserDto);
    }
}