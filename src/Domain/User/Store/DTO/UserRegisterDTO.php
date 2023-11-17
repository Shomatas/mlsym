<?php

namespace App\Domain\User\Store\DTO;

readonly class UserRegisterDTO
{

    public function __construct(
        public UserDTO $userDTO,
    )
    {

    }
}