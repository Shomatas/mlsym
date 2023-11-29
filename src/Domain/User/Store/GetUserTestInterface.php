<?php

namespace App\Domain\User\Store;

use App\Domain\User\Store\DTO\UserDTO;
use Symfony\Component\Uid\Uuid;

interface GetUserTestInterface
{
    public function get(Uuid $id): UserDTO;
    public function getLast(): UserDTO;
}