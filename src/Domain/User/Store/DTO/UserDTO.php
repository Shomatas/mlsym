<?php

namespace App\Domain\User\Store\DTO;

use App\Domain\Address\Address;
use App\Domain\User\Profile;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

readonly class UserDTO
{
    public function __construct(
        #[Assert\NotBlank]
        public Address $address,

        #[Assert\NotBlank]
        public Profile $profile,

        public ?Uuid $id = null,

        #[Assert\NotBlank]
        public string $login = "",

        #[Assert\NotBlank]
        public string $password = "",

        #[Assert\Email()]
        #[Assert\NotBlank]
        public string $email = "",

        public string $phone = "",
    )
    {

    }
}