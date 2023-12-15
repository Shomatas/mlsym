<?php

namespace App\Domain\User\Store;

use App\Domain\User\Store\DTO\UserDTO;

interface UserDtoMapperInterface
{
    public function mapToArray(UserDTO $userDTO): array;
    public function mapToJson(UserDTO $userDTO): string;
}