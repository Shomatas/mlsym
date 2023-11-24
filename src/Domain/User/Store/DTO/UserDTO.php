<?php

namespace App\Domain\User\Store\DTO;

use App\Domain\Address\Address;
use App\Domain\User\Profile;
use App\Domain\User\User;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

readonly class UserDTO
{
    public function __construct(
        #[Assert\NotBlank]
        public ?Uuid $id = null,

        #[Assert\NotBlank]
        public string $login = "",

        #[Assert\NotBlank]
        public string $password = "",

        #[Assert\NotBlank]
        public ?Profile $profile = null,

        #[Assert\NotBlank]
        public ?Address $address = null,

        #[Assert\Email()]
        #[Assert\NotBlank]
        public string $email = "",

        public ?string $phone = null,
    )
    {

    }

    public static function createFromUser(User $user): self
    {
        return new UserDTO(
            $user->getId(),
            $user->getLogin(),
            $user->getPassword(),
            $user->getProfile(),
            $user->getAddress(),
            $user->getEmail(),
            $user->getPhone(),
        );
    }
}