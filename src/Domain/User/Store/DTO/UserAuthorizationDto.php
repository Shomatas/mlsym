<?php

namespace App\Domain\User\Store\DTO;

readonly class UserAuthorizationDto
{
    public function __construct(
        public string $login = "",
        public string $password = "",
    )
    {
    }
}