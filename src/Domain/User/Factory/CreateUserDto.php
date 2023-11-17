<?php

namespace App\Domain\User\Factory;

use App\Domain\User\Store\DTO\UserDTO;

readonly class CreateUserDto
{
    public function __construct(
        public UserDTO $userDto,
    )
    {

    }
}