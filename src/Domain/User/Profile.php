<?php

namespace App\Domain\User;

use Symfony\Component\Validator\Constraints as Assert;

class Profile
{
    public function __construct(
        #[Assert\NotBlank]
        private string $firstName = "",
        #[Assert\NotBlank]
        private string $lastName = "",
        #[Assert\NotBlank]
        private int $age = 0,

        private string $avatar = "",
    )
    {

    }
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    public function getAvatar(): string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): void
    {
        $this->avatar = $avatar;
    }
}