<?php

namespace App\Domain\User\Store\DTO;

readonly class UserRegisterDTO
{

    public function __construct(
        public UserDTO $userDTO,
        public string $tempPathAvatar = "",
    )
    {

    }

    public function getPathToAvatar(): string
    {
        return $this->userDTO->profile->getAvatar()->getPathToFile();
    }
}