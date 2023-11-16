<?php

namespace App\Domain\User\Store\DTO;

readonly class UserDTO
{
    public function __construct(
        public int $id = 0,
        public string $login = "paff",
        public string $password = "1234",
    )
    {

    }
}