<?php

namespace App\Domain\Address\Store;

use App\Domain\Address\Store\DTO\AddressRegisterDTO;

interface AddressRegistrationInterface
{
    public function save(AddressRegisterDTO $addressRegisterDTO): void;
}