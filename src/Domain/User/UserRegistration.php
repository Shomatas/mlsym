<?php

namespace App\Domain\User;

use App\Domain\User\Store\DTO\UserRegisterDTO;
use App\Domain\User\Store\SaveUserInterface;

class UserRegistration
{

    public function __construct(
        private SaveUserInterface $userSaver,
    )
    {

    }
    public function register(User $user): int
    {
        $dto = new UserRegisterDTO($user->getLogin(), $user->getPassword());
        return $this->userSaver->save($dto);
    }
}