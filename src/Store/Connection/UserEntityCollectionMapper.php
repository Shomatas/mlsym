<?php

namespace App\Store\Connection;

class UserEntityCollectionMapper
{
    public function mapToArray(array $userEntityCollection): array
    {
        $collection = [];
        foreach ($userEntityCollection as $key => $userEntity) {
            $collection[] = [
                "id" => $userEntity->getId(),
                "login" => $userEntity->getLogin(),
                "password" => $userEntity->getPassword(),
                "profile" => [
                    "firstname" => $userEntity->getFirstname(),
                    "lastname" => $userEntity->getLastname(),
                    "age" => $userEntity->getAge(),
                    "avatar" => [
                        "path_to_avatar" => $userEntity->getPathToAvatar(),
                        "avatar_mime_type" => $userEntity->getAvatarMimeType(),
                    ]
                ],
                "address" => [
                    "country" => $userEntity->getCountry(),
                    "city" => $userEntity->getCity(),
                    "street" => $userEntity->getStreet(),
                    "house_number" => $userEntity->getHouseNumber(),
                ],
                "email" => $userEntity->getEmail(),
                "phone" => $userEntity->getPhone(),
            ];
        }
        return $collection;
    }
}