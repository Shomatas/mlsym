<?php

namespace App\Domain\User\Factory;

use App\Domain\User\Exception\UserValidationException;
use App\Domain\User\User;
use Symfony\Component\Uid\Uuid;
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
        $result = $this->validator->validate($createUserDto->userDto);

        if ($result->count() > 0) {
            throw new UserValidationException("Провалена валидация пользователя");
        }

        $id = Uuid::v1();

        return new User(
            $id,
            $createUserDto->userDto->address,
            $createUserDto->userDto->profile,
            $createUserDto->userDto->login,
            $createUserDto->userDto->password,
            $createUserDto->userDto->email,
            $createUserDto->userDto->phone,
        );
    }
}