<?php

namespace App\Domain\User;

use App\Domain\Exception\DomainException;
use App\Domain\Exception\SystemException;
use App\Domain\User\Exception\CreateUserException;
use App\Domain\User\Exception\SaveUserException;
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

        try {
            $user = $this->userFactory->create($createUserDto);
        } catch (DomainException $exception) {
            throw new CreateUserException("Во время создания сущности пользователя произошла ошибка");
        } catch (\Throwable $exception) {
            throw new SystemException("Системная ошибка");
        }
        $userDto = UserDTO::createFromUser($user);

        $saveUserDto = new SaveUserDto($userDto, $createUserDto->pathTempFileAvatar, $createUserDto->avatarMimeType);

        try {
            $this->userSaver->save($saveUserDto);
        } catch (\Throwable $exception) {
            throw new SaveUserException;
        }
    }
}