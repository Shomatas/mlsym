<?php

namespace App\Domain\User\Factory;

use App\Domain\Address\Factory\AddressFactory;
use App\Domain\User\Avatar;
use App\Domain\User\Exception\UserValidationException;
use App\Domain\User\Factory\DTO\CreateUserDto;
use App\Domain\User\Profile;
use App\Domain\User\Store\DTO\FileSaveDto;
use App\Domain\User\Store\SaveFileInterface;
use App\Domain\User\User;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserFactory
{
    public function __construct(
        private ValidatorInterface $validator,
        private SaveFileInterface $fileSaver,
        private AddressFactory $addressFactory,
    )
    {

    }

    public function create(CreateUserDto $createUserDto): User
    {
        $result = $this->validator->validate($createUserDto);
        $result->addAll($this->validator->validate($createUserDto->address));
        $result->addAll($this->validator->validate($createUserDto->profile));

        if ($result->count() > 0) {
            throw new UserValidationException($result);
        }

        $profile = new Profile(
            $createUserDto->profile->firstname,
            $createUserDto->profile->lastname,
            $createUserDto->profile->age,
            new Avatar(),
        );

        $address = $this->addressFactory->create($createUserDto->address);

        $id = Uuid::v1();

        return new User(
            $id,
            $createUserDto->login,
            $createUserDto->password,
            $profile,
            $address,
            $createUserDto->email,
            $createUserDto->phone,
        );
    }
}