<?php

namespace App\Domain\User\Store;

use App\Domain\User\Store\DTO\PatchUserDto;

interface PatchUserInterface
{
    public function patch(PatchUserDto $patchUserDto): void;
}