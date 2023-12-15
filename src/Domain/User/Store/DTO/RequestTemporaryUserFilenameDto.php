<?php

namespace App\Domain\User\Store\DTO;

readonly class RequestTemporaryUserFilenameDto
{
    public function __construct(
        public string $login = "",
        public string $password = "",
        public string $firstname = "",
        public string $lastname = "",
        public ?int $age = null,
        public string $country = "",
        public string $city = "",
        public string $street = "",
        public string $houseNumber = "",
        public string $email = "",
        public string $phone = "",
    )
    {

    }

    public function isEquals(RequestTemporaryUserFilenameDto $requestTemporaryUserFilenameDto): bool
    {
        return $this->login === $requestTemporaryUserFilenameDto->login
            && $this->password === $requestTemporaryUserFilenameDto->password
            && $this->firstname === $requestTemporaryUserFilenameDto->firstname
            && $this->lastname === $requestTemporaryUserFilenameDto->lastname
            && $this->age === $requestTemporaryUserFilenameDto->age
            && $this->country === $requestTemporaryUserFilenameDto->country
            && $this->city === $requestTemporaryUserFilenameDto->city
            && $this->street === $requestTemporaryUserFilenameDto->street
            && $this->houseNumber === $requestTemporaryUserFilenameDto->houseNumber
            && $this->email === $requestTemporaryUserFilenameDto->email
            && $this->phone === $requestTemporaryUserFilenameDto->phone;

    }

    public static function createFromArray(array $data): self
    {
        return new RequestTemporaryUserFilenameDto(
            $data["login"],
            $data["password"],
            $data["profile"]["firstname"] ?? $data["firstname"],
            $data["profile"]["lastname"] ?? $data["lastname"],
            $data["profile"]["age"] ?? $data["age"],
            $data["address"]["country"] ?? $data["country"],
            $data["address"]["city"] ?? $data["city"],
            $data["address"]["street"] ?? $data["street"],
            $data["address"]["house_number"] ?? $data["house_number"],
            $data["email"],
            $data["phone"],
        );
    }

    public static function createFromUserRegisterDto(UserRegisterDTO $userRegisterDTO): self
    {
        return new RequestTemporaryUserFilenameDto(
            $userRegisterDTO->login,
            $userRegisterDTO->password,
            $userRegisterDTO->profile->firstname,
            $userRegisterDTO->profile->lastname,
            $userRegisterDTO->profile->age,
            $userRegisterDTO->address->country,
            $userRegisterDTO->address->city,
            $userRegisterDTO->address->street,
            $userRegisterDTO->address->houseNumber,
            $userRegisterDTO->email,
            $userRegisterDTO->phone,
        );
    }

    public static function createFromJson(string $data): self
    {
        return static::createFromArray(json_decode($data, true));
    }
}