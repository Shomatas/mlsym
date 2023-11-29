<?php

namespace App\Domain\User\Store;

use App\Domain\User\Store\DTO\SaveUserDto;

interface SaveUserInterface
{
    public function save(SaveUserDto $dto): void;
}