<?php

namespace App\Domain\User\Factory;

use App\Domain\Address\Factory\AddressFactory;
use App\Domain\User\Avatar;
use App\Domain\User\Exception\UserValidationException;
use App\Domain\User\Factory\DTO\CreateUserDto;
use App\Domain\User\Profile;
use App\Domain\User\User;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserFactory
{
    public function __construct(
        private ValidatorInterface $validator,
        private AddressFactory $addressFactory,
    )
    {

    }

    public function create(CreateUserDto $createUserDto): User
    {
        $this->validateCreateUserDtoAndThrowFoundErrors($createUserDto);
        $profile = $this->createProfile($createUserDto);
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

    private function validateCreateUserDtoAndThrowFoundErrors(CreateUserDto $createUserDto): void
    {
        $result = $this->getConstraintViolationListInterfaceFromValidationCreateUserDto($createUserDto);
        $this->throwFoundErrorsFromConstraintViolationListInterface($result);
    }

    private function getConstraintViolationListInterfaceFromValidationCreateUserDto(
        CreateUserDto $createUserDto
    ): ConstraintViolationListInterface
    {
        $result = $this->validator->validate($createUserDto);
        $result->addAll($this->validator->validate($createUserDto->address));
        $result->addAll($this->validator->validate($createUserDto->profile));
        return $result;
    }

    private function throwFoundErrorsFromConstraintViolationListInterface(
        ConstraintViolationListInterface $constraintViolationList
    ): void
    {
        if ($constraintViolationList->count() > 0) {
            throw new UserValidationException($constraintViolationList);
        }
    }

    private function createProfile(CreateUserDto $createUserDto): Profile
    {
        return new Profile(
            $createUserDto->profile->firstname,
            $createUserDto->profile->lastname,
            $createUserDto->profile->age,
            new Avatar(),
        );
    }
}