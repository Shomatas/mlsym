<?php

namespace App\Store\User;

use App\Domain\Address\Address;
use App\Domain\Address\Store\DTO\AddressDto;
use App\Domain\User\Avatar;
use App\Domain\User\Profile;
use App\Domain\User\Store\DTO\AvatarDto;
use App\Domain\User\Store\DTO\Collection\UserDtoCollection;
use App\Domain\User\Store\DTO\ProfileDto;
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

    public function mapToArray(UserDtoCollection $collectionDTO): array
    {
        $collection = [];
        foreach ($collectionDTO as $key => $userDto) {
            $collection[] = $this->dtoMapper->mapToArray($userDto);
        }
        return $collection;
    }

    public function mapToJson(UserDtoCollection $collectionDTO): string
    {
        return json_encode($this->mapToArray($collectionDTO), JSON_UNESCAPED_UNICODE);
    }

    public function mapFromArray(array $data): UserDtoCollection
    {
        $collection = new UserDtoCollection();
        foreach ($data as $key => $userData) {
            $collection[] = new UserDTO(
                $userData["id"],
                $userData["login"],
                $userData["password"],
                new ProfileDto(
                    $userData["profile"]["firstname"],
                    $userData["profile"]["lastname"],
                    $userData["profile"]["age"],
                    new AvatarDto(),
                ),
                new AddressDto(
                    $userData["address"]["country"],
                    $userData["address"]["city"],
                    $userData["address"]["country"],
                    $userData["address"]["country"],
                ),
                $userData["email"],
                $userData["phone"],
            );
        }
        return $collection;
    }
}