<?php

namespace App\Domain\User\Store\DTO;

readonly class UserRegisterDTO
{
    public function __construct(
        public string $login,
        public string $password,
    )
    {

    }
}