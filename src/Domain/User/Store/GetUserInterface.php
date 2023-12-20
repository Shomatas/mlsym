<?php

namespace App\Domain\User\Store;

use App\Domain\User\Store\DTO\Collection\UserDtoCollection;
use App\Domain\User\Store\DTO\UserDTO;

interface GetUserInterface
{
    public function getAll(): UserDtoCollection;
    public function getByLogin(string $login): UserDTO;
}