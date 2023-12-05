<?php

namespace App\Domain\User;

use App\Domain\Address\Factory\CreateAddressDto;
use App\Domain\User\Factory\DTO\CreateProfileDto;
use App\Domain\User\Factory\DTO\CreateUserDto;
use App\Domain\User\Factory\UserFactory;
use App\Domain\User\Store\DTO\SaveUserDto;
use App\Domain\User\Store\DTO\UserDTO;
use App\Domain\User\Store\DTO\UserRegisterDTO;
use App\Domain\User\Store\SaveUserInterface;

class UserRegistration
{


    public function __construct(
        private SaveUserInterface $userSaver,
        private UserFactory $userFactory,
    )
    {

    }
    public function register(UserRegisterDTO $dto): void
    {
        $createUserDto = CreateUserDto::createFromUserRegisterDto($dto);

        $user = $this->userFactory->create($createUserDto);
        $userDto = UserDTO::createFromUser($user);

        $saveUserDto = new SaveUserDto($userDto, $createUserDto->pathTempFileAvatar, $createUserDto->avatarMimeType);

        $this->userSaver->save($saveUserDto);
    }
}