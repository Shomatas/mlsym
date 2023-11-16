<?php

namespace App\Domain\User\Store;

use App\Domain\User\Store\DTO\UserRegisterDTO;

interface SaveUserInterface
{
    /**
     * @param UserRegisterDTO $dto
     * @return int Возвращает id нового объекта
     */
    public function save(UserRegisterDTO $dto): int;
}