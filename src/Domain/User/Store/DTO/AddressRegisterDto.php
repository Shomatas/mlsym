<?php

namespace App\Domain\User\Store\DTO;

readonly class AddressRegisterDto
{
    public function __construct(
        public string $country = "",
        public string $city = "",
        public string $street = "",
        public string $houseNumber = "",
    )
    {

    }
}