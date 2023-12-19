<?php

namespace App\Domain\Address\Factory;

use App\Domain\Address\Address;
use App\Domain\Address\Exception\AddressFactoryException;
use App\Domain\User\Factory\DTO\CreateUserDto;
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
        $this->validateCreateAddressDtoAndThrowFoundErrors($createAddressDto);
        return Address::createFromCreateUserDto($createAddressDto);
    }

    private function validateCreateAddressDtoAndThrowFoundErrors(CreateAddressDto $createAddressDto): void
    {
        $result = $this->validator->validate($createAddressDto);
        if ($result->count() > 0) {
            throw new AddressFactoryException("Валидация не пройдена");
        }
    }
}