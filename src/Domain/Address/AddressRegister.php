<?php

namespace App\Domain\Address;

use App\Domain\Address\Store\AddressRegistrationInterface;
use App\Domain\Address\Store\DTO\AddressRegisterDTO;

class AddressRegister
{
    public function __construct(
        private AddressRegistrationInterface $addressRegistration,
    )
    {

    }
    public function register(Address $address): void
    {
        $dto = new AddressRegisterDTO();
        $data = $this->addressRegistration->save($dto);
    }
}