<?php

namespace App\Domain\User\Factory;

use App\Domain\User\Avatar;
use App\Domain\User\Exception\UserValidationException;
use App\Domain\User\Profile;
use App\Domain\User\Store\DTO\AvatarDto;
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

    public function create(CreateUserDto $createUserDto, AvatarDto $avatarDto = null): User
    {
        $profile = $createUserDto->profile;
        if (!is_null($avatarDto)) {
            $profile = new Profile(
                $createUserDto->profile->getFirstName(),
                $createUserDto->profile->getLastName(),
                $createUserDto->profile->getAge(),
                new Avatar($avatarDto->pathToFile, $avatarDto->mimeType),
            );
        }

        $result = $this->validator->validate($createUserDto);
        $result->addAll($this->validator->validate($profile));
        $result->addAll($this->validator->validate($profile->getAvatar()));

        if ($result->count() > 0) {
            throw new UserValidationException($result);
        }

        $id = Uuid::v1();

        return new User(
            $id,
            $createUserDto->login,
            $createUserDto->password,
            $profile,
            $createUserDto->address,
            $createUserDto->email,
            $createUserDto->phone,
        );
    }
}