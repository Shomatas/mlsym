<?php

namespace App\Domain\User\Factory;

use App\Domain\User\User;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserFactory
{
    public function __construct(
        private ValidatorInterface $validator,
    )
    {

    }

    public function create(CreateUserDto $createUserDto): User
    {
        $this->validator->validate($createUserDto->userDto);

        return new User(
            $createUserDto->userDto->address,
            $createUserDto->userDto->login,
            $createUserDto->userDto->password,
            $createUserDto->userDto->firstName,
            $createUserDto->userDto->lastName,
            $createUserDto->userDto->age,
            $createUserDto->userDto->email,
            $createUserDto->userDto->phone,
        );
    }
}