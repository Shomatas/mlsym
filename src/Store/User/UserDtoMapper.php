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
                "firstname" => $userDTO->profile->getFirstName(),
                "lastname" => $userDTO->profile->getLastName(),
                "age" => $userDTO->profile->getAge(),
                "avatar" => [
                    "path_to_avatar" => $userDTO->profile->getAvatar()->getPathToFile(),
                ],
            ],
            "address" => [
                "country" => $userDTO->address->getCountry(),
                "city" => $userDTO->address->getCity(),
                "street" => $userDTO->address->getStreet(),
                "house_number" => $userDTO->address->getHouseNumber(),
            ],
            "email" => $userDTO->email,
            "phone" => $userDTO->phone,
        ];
    }
}