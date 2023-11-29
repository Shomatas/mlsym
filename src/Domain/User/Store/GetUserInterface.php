<?php

namespace App\Domain\User\Store;

use App\Domain\User\Store\DTO\Collection\UserDtoCollection;

interface GetUserInterface
{
    public function getAll(): UserDtoCollection;
}