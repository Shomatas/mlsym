<?php

namespace App\Domain\Address;

use App\Domain\Address\Factory\CreateAddressDto;

class Address
{
    public function __construct(
        private string $country = "",
        private string $city = "",
        private string $street = "",
        private string $houseNumber = "",
    )
    {

    }

    public static function createFromCreateUserDto(CreateAddressDto $createAddressDto): self
    {
        return new Address(
            $createAddressDto->country,
            $createAddressDto->city,
            $createAddressDto->street,
            $createAddressDto->houseNumber,
        );
    }
    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function setStreet(string $street): void
    {
        $this->street = $street;
    }

    public function getHouseNumber(): string
    {
        return $this->houseNumber;
    }

    public function setHouseNumber(string $houseNumber): void
    {
        $this->houseNumber = $houseNumber;
    }
    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
    }
}