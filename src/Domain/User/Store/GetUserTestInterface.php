<?php

namespace App\Domain\User\Store;

use App\Domain\User\Store\DTO\UserDTO;

interface GetUserTestInterface
{
    public function get(int $id): UserDTO;
}