<?php

namespace App\Domain\User\Store;

use App\Domain\User\Store\DTO\UserRegisterDTO;

interface SaveUserInterface
{
    /**
     * @param UserRegisterDTO $dto
     */
    public function save(UserRegisterDTO $dto): void;
}