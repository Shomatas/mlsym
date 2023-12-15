<?php

namespace App\Domain\User\Store;

use App\Domain\User\Store\DTO\SaveUserDto;

interface TemporarySaveUserDtoInterface
{
    public function save(SaveUserDto $saveUserDto): void;
    public function pop(string $id): SaveUserDto;
}