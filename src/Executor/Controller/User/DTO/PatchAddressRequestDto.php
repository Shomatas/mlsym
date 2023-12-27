<?php

namespace App\Executor\Controller\User\DTO;

readonly class PatchAddressRequestDto
{
    public function __construct(
        public mixed $country = null,
        public mixed $city = null,
        public mixed $street = null,
        public mixed $houseNumber = null,
    )
    {
    }
}