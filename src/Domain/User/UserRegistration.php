<?php

namespace App\Domain\User;

use App\Domain\User\Factory\CreateUserDto;
use App\Domain\User\Factory\UserFactory;
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
        $createUserDto = new CreateUserDto(
            $dto->login,
            $dto->password,
            new Profile(
                $dto->profile->getFirstName(),
                $dto->profile->getLastName(),
                $dto->profile->getAge(),
            ),
            $dto->address,
            $dto->email,
            $dto->phone,
            $dto->tempPathAvatar,
            $dto->avatarMimeType,
        );

        $user = $this->userFactory->create($createUserDto);
        $userDto = UserDTO::createFromUser($user);

        $this->userSaver->save($userDto);
    }
}