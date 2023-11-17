<?php

namespace App\Domain\User\Store\DTO;

use App\Domain\Address\Address;
use Symfony\Component\Validator\Constraints as Assert;

readonly class UserDTO
{
    public function __construct(
        #[Assert\NotBlank]
        public Address $address,

        #[Assert\NotBlank]
        public string $login = "",

        #[Assert\NotBlank]
        public string $password = "",

        #[Assert\NotBlank]
        public string $firstName = "",

        #[Assert\NotBlank]
        public string $lastName = "",

        #[Assert\NotBlank]
        public int $age = 0,

        #[Assert\Email()]
        #[Assert\NotBlank]
        public string $email = "",

        public string $phone = "",
    )
    {

    }
}