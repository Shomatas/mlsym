<?php

namespace App\Domain\User\Store\DTO;

readonly class SaveUserDto
{
    public function __construct(
        public ?UserDTO $userDTO = null,
        public string $tempUrlAvatar = "",
        public string $mimeType = "",
    )
    {

    }
}