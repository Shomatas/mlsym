<?php

namespace App\Domain\User\Store;

use App\Domain\User\Store\DTO\UserDTO;
use Symfony\Component\Uid\Uuid;

interface GetUserTestInterface
{
    public function getLast(): UserDTO;
    public function getDataSize(): int;
}