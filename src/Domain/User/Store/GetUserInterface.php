<?php

namespace App\Domain\User\Store;

use App\Domain\User\Store\DTO\UserCollectionDTO;

interface GetUserInterface
{
    public function getAll(): UserCollectionDTO;
}