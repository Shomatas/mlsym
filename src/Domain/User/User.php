<?php

namespace App\Domain\User;


class User
{
    public function __construct(
        private string $login = "paff",
        private string $password = "1234",
    )
    {
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