<?php

namespace App\Domain\Address\Store\DTO;

use Symfony\Component\Validator\Constraints as Assert;

readonly class AddressDto
{
    #[Assert\NotBlank]
    public string $country;
    #[Assert\NotBlank]
    public string $city;
    #[Assert\NotBlank]
    public string $street;
    #[Assert\NotBlank]
    public string $houseNumber;

    public function __construct(string $country = "", string $city = "", string $street = "", string $houseNumber = "")
    {
        $this->country = $country;
        $this->city = $city;
        $this->street = $street;
        $this->houseNumber = $houseNumber;
    }

}