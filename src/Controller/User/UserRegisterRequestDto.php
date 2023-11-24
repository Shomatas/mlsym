<?php

namespace App\Controller\User;

use Symfony\Component\Validator\Constraints as Assert;

readonly class UserRegisterRequestDto
{
    public function __construct(
        #[Assert\NotBlank()]
        public mixed $login = null,
        #[Assert\NotBlank()]
        public mixed $password = null,
        #[Assert\NotBlank()]
        public ?ProfileRequestDto $profile = null,
        #[Assert\NotBlank()]
        public ?AddressRequestDto $address = null,
        #[Assert\NotBlank()]
        public mixed $email = null,
        public mixed $phone = null,
    )
    {

    }
}