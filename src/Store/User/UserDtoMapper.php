<?php

namespace App\Store\User;

use App\Domain\User\Store\DTO\UserDTO;
use App\Domain\User\Store\UserDtoMapperInterface;

class UserDtoMapper implements UserDtoMapperInterface
{

    public function mapToArray(UserDTO $userDTO): array
    {
        return [
            "id" => $userDTO->id,
            "login" => $userDTO->login,
            "password" => $userDTO->password,
            "profile" => [
                "firstname" => $userDTO->profile->firstname,
                "lastname" => $userDTO->profile->lastname,
                "age" => $userDTO->profile->age,
                "avatar" => [],
            ],
            "address" => [
                "country" => $userDTO->address->country,
                "city" => $userDTO->address->city,
                "street" => $userDTO->address->street,
                "house_number" => $userDTO->address->houseNumber,
            ],
            "email" => $userDTO->email,
            "phone" => $userDTO->phone,
        ];
    }
}