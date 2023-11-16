<?php

namespace App\Domain\User\Store\DTO;

readonly class UserDTO
{
    public function __construct(
        public int $id,
        public string $login,
        public string $password,
    )
    {

    }
}