<?php

namespace App\Tests\Domain\User;

use App\Domain\User\Store\DTO\UserDTO;

interface GetUserInterface
{
    public function get(int $id): UserDTO;
}