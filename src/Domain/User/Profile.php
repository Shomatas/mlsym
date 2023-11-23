<?php

namespace App\Domain\User;

use Symfony\Component\Validator\Constraints as Assert;

class Profile
{
    public function __construct(
        #[Assert\NotBlank]
        private string $firstname = "",
        #[Assert\NotBlank]
        private string $lastname = "",
        #[Assert\NotBlank]
        private int $age = 0,

        private ?Avatar $avatar = null,
    )
    {

    }
    public function getFirstName(): string
    {
        return $this->firstname;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstname = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastname;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastname = $lastName;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    public function getAvatar(): ?Avatar
    {
        return $this->avatar;
    }

    public function setAvatar(?Avatar $avatar): void
    {
        $this->avatar = $avatar;
    }
}