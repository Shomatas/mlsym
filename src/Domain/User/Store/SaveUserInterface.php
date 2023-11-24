<?php

namespace App\Domain\User\Store;

use App\Domain\User\Store\DTO\UserDTO;

interface SaveUserInterface
{
    public function save(UserDTO $dto): void;
}