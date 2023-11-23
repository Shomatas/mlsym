<?php

namespace App\Domain\User\Store\DTO;

use App\Domain\User\Exception\UserCollectionException;

class UserCollectionDTO
{
    private array $collection = [];

    public function getCollection(): array
    {
        return $this->collection;
    }

    public function add(UserDTO $userDTO): void
    {
        $this->collection[] = $userDTO;
    }

    public function mapArrayOfUserDto(array $data): void
    {
        foreach ($data as $key => $userDto) {
            if (!is_a($userDto, UserDTO::class)) {
                throw new UserCollectionException;
            }
            $this->add($userDto);
        }
    }
}