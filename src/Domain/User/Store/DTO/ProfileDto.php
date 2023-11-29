<?php

namespace App\Domain\User\Store\DTO;

readonly class ProfileDto
{
    public function __construct(
        public string $firstname = "",
        public string $lastname = "",
        public int $age = 0,
        public ?AvatarDto $avatar = null,
    )
    {

    }
}