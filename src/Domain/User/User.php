<?php

namespace App\Domain\User;


use App\Domain\Address\Address;
use Symfony\Component\Uid\Uuid;

class User
{
    public function __construct(
        private ?Uuid $id,
        private string $login = "",
        private string $password = "",
        private ?Profile $profile = null,
        private ?Address $address = null,
        private string $email = "",
        private ?string $phone = null,
    )
    {
    }

    public function getProfile(): Profile
    {
        return $this->profile;
    }

    public function setProfile(Profile $profile): void
    {
        $this->profile = $profile;
    }
    public function getId(): Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): void
    {
        $this->id = $id;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): void
    {
        $this->address = $address;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }


    public function getLogin(): string
    {
        return $this->login;
    }

    public function getPassword(): string
    {
        return $this->password;
    }


}