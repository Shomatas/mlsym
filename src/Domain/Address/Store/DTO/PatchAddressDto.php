<?php

namespace App\Domain\Address\Store\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class PatchAddressDto
{
    public function __construct(
        #[Assert\Length(min: 1)]
        public ?string $country = null,
        #[Assert\Length(min: 1)]
        public ?string $city = null,
        #[Assert\Length(min: 1)]
        public ?string $street = null,
        #[Assert\Length(min: 1)]
        public ?string $houseNumber = null,
    )
    {
    }
}