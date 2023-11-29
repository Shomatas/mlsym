<?php

namespace App\Domain\User\Store\DTO;

readonly class ProfileRegisterDto
{
    public function __construct(
        public string $firstname = "",
        public string $lastname = "",
        public int $age = 0,
    )
    {

    }
}