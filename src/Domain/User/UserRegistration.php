<?php

namespace App\Domain\User;

use App\Domain\User\Store\DTO\UserDTO;
use App\Domain\User\Store\DTO\UserRegisterDTO;
use App\Domain\User\Store\SaveUserInterface;

class UserRegistration
{

    public function __construct(
        private SaveUserInterface $userSaver,
    )
    {

    }
    public function register(UserDTO $userDto): int
    {
        $dto = new UserRegisterDTO($userDto);
        return $this->userSaver->save($dto);
    }
}