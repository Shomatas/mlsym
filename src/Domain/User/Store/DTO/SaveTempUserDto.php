<?php

namespace App\Domain\User\Store\DTO;

use App\Domain\User\Factory\DTO\CreateUserDto;

readonly class SaveTempUserDto
{
    public function __construct(
        public UserDTO $userDto,
        public CreateUserDto $createUserDto,
    )
    {
    }
}