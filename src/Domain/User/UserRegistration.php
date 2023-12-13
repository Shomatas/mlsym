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
use Psr\Log\LoggerInterface;

class UserRegistration
{
    public function __construct(
        private SaveUserInterface $userSaver,
        private UserFactory $userFactory,
        private LoggerInterface $storeLogger,
        private LoggerInterface $userFactoryLogger,
    )
    {

    }

    public function register(UserRegisterDTO $dto): void
    {
        $createUserDto = CreateUserDto::createFromUserRegisterDto($dto);
        $user = $this->getUserFromUserFactory($createUserDto);
        $userDto = UserDTO::createFromUser($user);
        $saveUserDto = new SaveUserDto($userDto, $createUserDto->pathTempFileAvatar, $createUserDto->avatarMimeType);
        $this->runSaveUser($saveUserDto);
    }

    private function getUserFromUserFactory(CreateUserDto $dto): User
    {
        try {
            $user = $this->userFactory->create($dto);
        } catch (DomainException $exception) {
            throw new CreateUserException("Во время создания сущности пользователя произошла ошибка");
        } catch (\Throwable $exception) {
            $this->userFactoryLogger->error($exception->getMessage());
            throw new SystemException("Системная ошибка");
        }
        return $user;
    }

    private function runSaveUser(SaveUserDto $saveUserDto): void
    {
        try {
            $this->userSaver->save($saveUserDto);
        } catch (\Throwable $exception) {
            $this->storeLogger->error($exception->getMessage());
            throw new SaveUserException;
        }
    }
}