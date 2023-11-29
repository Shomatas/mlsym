<?php

namespace App\Executor\User;

use Symfony\Component\Validator\Constraints as Assert;

readonly class AddressRequestDto
{
    public function __construct(
        #[Assert\NotBlank()]
        public mixed $country = null,
        #[Assert\NotBlank()]
        public mixed $city = null,
        #[Assert\NotBlank()]
        public mixed $street = null,
        #[Assert\NotBlank()]
        public mixed $houseNumber = null,
    )
    {}
}