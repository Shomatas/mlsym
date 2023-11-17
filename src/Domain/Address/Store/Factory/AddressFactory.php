<?php

namespace App\Domain\Address\Store\Factory;

use App\Domain\Address\Address;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddressFactory
{
    public function __construct(
        private ValidatorInterface $validator,
    )
    {

    }

    public function create(CreateAddressDto $createAddressDto): Address
    {
        $result = $this->validator->validate($createAddressDto->addressDto);

        if ($result->count() > 0) {
            throw new \Exception("Валидация не пройдена");
        }

        return new Address(
            $createAddressDto->addressDto->country,
            $createAddressDto->addressDto->city,
            $createAddressDto->addressDto->street,
            $createAddressDto->addressDto->houseNumber,
        );
    }
}