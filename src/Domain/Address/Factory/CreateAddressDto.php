<?php

namespace App\Domain\Address\Factory;

use App\Domain\Address\Store\DTO\AddressDto;

readonly class CreateAddressDto
{
    public function __construct(
        public AddressDto $addressDto,
    )
    {

    }
}