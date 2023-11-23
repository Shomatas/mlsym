<?php

namespace App\Store\User;

use App\Domain\Address\Address;
use App\Domain\User\Avatar;
use App\Domain\User\Profile;
use App\Domain\User\Store\DTO\UserCollectionDTO;
use App\Domain\User\Store\DTO\UserDTO;
use App\Domain\User\Store\UserCollectionDtoMapperInterface;
use App\Domain\User\Store\UserDtoMapperInterface;

class UserCollectionDtoMapper implements UserCollectionDtoMapperInterface
{
    public function __construct(
        private UserDtoMapperInterface $dtoMapper,
    )
    {

    }

    public function mapToArray(UserCollectionDTO $collectionDTO): array
    {
        $collection = [];
        foreach ($collectionDTO->getCollection() as $key => $userDto) {
            $collection[] = $this->dtoMapper->mapToArray($userDto);
        }
        return $collection;
    }

    public function mapToJson(UserCollectionDTO $collectionDTO): string
    {
        return json_encode($this->mapToArray($collectionDTO), JSON_UNESCAPED_UNICODE);
    }

    public function mapFromArray(array $data): UserCollectionDTO
    {
        $collection = new UserCollectionDTO();
        foreach ($data as $key => $userData) {
            $collection->add(new UserDTO(
                $userData["id"],
                $userData["login"],
                $userData["password"],
                new Profile(
                    $userData["profile"]["firstname"],
                    $userData["profile"]["lastname"],
                    $userData["profile"]["age"],
                    new Avatar(
                        $userData["profile"]["avatar"]["path_to_avatar"],
                        $userData["profile"]["avatar"]["avatar_mime_type"],
                    ),
                ),
                new Address(
                    $userData["address"]["country"],
                    $userData["address"]["city"],
                    $userData["address"]["country"],
                    $userData["address"]["country"],
                ),
                $userData["email"],
                $userData["phone"],
            ));
        }
        return $collection;
    }
}