<?php

namespace App\Domain\User\Store\DTO;

use App\Domain\Address\Address;
use App\Domain\Address\Store\DTO\AddressDto;
use App\Domain\User\Profile;
use App\Domain\User\User;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

readonly class UserDTO
{
    public function __construct(
        public ?Uuid $id = null,
        public string $login = "",
        public string $password = "",
        public ?ProfileDto $profile = null,
        public ?AddressDto $address = null,
        public string $email = "",
        public ?string $phone = null,
        public bool $isConfirmed = false,
    )
    {

    }

    public static function createFromUser(User $user): self
    {
        return new UserDTO(
            $user->getId(),
            $user->getLogin(),
            $user->getPassword(),
            new ProfileDto(
                $user->getProfile()->getFirstName(),
                $user->getProfile()->getLastName(),
                $user->getProfile()->getAge(),
                new AvatarDto(),
            ),
            new AddressDto(
                $user->getAddress()->getCountry(),
                $user->getAddress()->getCity(),
                $user->getAddress()->getStreet(),
                $user->getAddress()->getHouseNumber(),
            ),
            $user->getEmail(),
            $user->getPhone(),
            $user->isConfirmed(),
        );
    }
}