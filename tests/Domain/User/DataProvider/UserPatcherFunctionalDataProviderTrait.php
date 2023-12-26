<?php

namespace App\Tests\Domain\User\DataProvider;

use App\Domain\User\Store\DTO\PatchUserDto;
use Symfony\Component\Uid\Uuid;

trait UserPatcherFunctionalDataProviderTrait
{
    public static function patchDataProvider(): array
    {
        $id = Uuid::fromString("1e59fcae-a3d5-11ee-9cac-d57c1d1841ac");
        return [
            "When login is changed" => [
                new PatchUserDto($id, "paff")
            ],
            "When password is changed" => [
                new PatchUserDto($id, password: "123")
            ],
            "When "
        ];
    }
}