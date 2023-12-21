<?php

namespace App\Domain\User\Store;

use App\Domain\User\Store\DTO\Collection\UserDtoCollection;
use App\Domain\User\Store\DTO\UserDTO;
use Symfony\Component\Uid\Uuid;

interface GetUserInterface
{
    public function getAll(): UserDtoCollection;
    public function get(Uuid $id): UserDTO;
}