<?php

namespace App\Domain\Address\Factory;

use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateAddressDto
{
    public function __construct(
        #[Assert\NotBlank]
        public string $country = "",
        #[Assert\NotBlank]
        public string $city = "",
        #[Assert\NotBlank]
        public string $street = "",
        #[Assert\NotBlank]
        public string $houseNumber = "",
    )
    {

    }
}