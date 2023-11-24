<?php

namespace App\Domain\User\Factory;

use App\Domain\User\Avatar;
use App\Domain\User\Exception\UserValidationException;
use App\Domain\User\Profile;
use App\Domain\User\Store\DTO\AvatarDto;
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

        $fileSaveDto = new FileSaveDto(
            $createUserDto->pathTempFileAvatar,
            $createUserDto->avatarMimeType,
        );

        $savedFileDto = $this->fileSaver->save($fileSaveDto);

        $profile = new Profile(
            $createUserDto->profile->getFirstName(),
            $createUserDto->profile->getLastName(),
            $createUserDto->profile->getAge(),
            new Avatar($savedFileDto->pathToAvatar),
        );

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