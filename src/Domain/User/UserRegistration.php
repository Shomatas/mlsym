<?php

namespace App\Domain\User;

use App\Domain\Exception\DomainException;
use App\Domain\Exception\SystemException;
use App\Domain\User\Exception\CreateUserException;
use App\Domain\User\Exception\SaveUserException;
use App\Domain\User\Factory\DTO\CreateUserDto;
use App\Domain\User\Factory\UserFactory;
use App\Domain\User\Notification\DTO\RegistrationMessageDto;
use App\Domain\User\Notification\RegistrationMessageInterface;
use App\Domain\User\Store\ConfirmingUserInterface;
use App\Domain\User\Store\DTO\SaveTempUserDto;
use App\Domain\User\Store\DTO\SaveUserDto;
use App\Domain\User\Store\DTO\UserDTO;
use App\Domain\User\Store\DTO\UserRegisterDTO;
use App\Domain\User\Store\SaveUserInterface;
use App\Domain\User\Store\TemporarySaveUserDtoInterface;
use App\Executor\Controller\User\DTO\UserRegisterRequestDto;
use App\Store\User\SaveUserDtoDataMapper;
use App\Store\User\TemporarySaveUserDto;
use Psr\Log\LoggerInterface;
use Symfony\Component\Uid\Uuid;

class UserRegistration
{
    public function __construct(
        private SaveUserInterface $userSaver,
        private UserFactory $userFactory,
        private LoggerInterface $storeLogger,
        private LoggerInterface $userFactoryLogger,
        private RegistrationMessageInterface $registrationMessage,
        private ConfirmingUserInterface $confirmingUser,
    ) {}

    public function prepareRegistration(UserRegisterDTO $dto)
    {
        $createUserDto = CreateUserDto::createFromUserRegisterDto($dto);
        $user = $this->getUserFromUserFactory($createUserDto);
        $userDto = UserDTO::createFromUser($user);
        $this->runSendingMessage($userDto);
        $saveUserDto = new SaveUserDto($userDto, $dto->tempPathAvatar, $dto->avatarMimeType);
        $this->runSaveUser($saveUserDto);
    }

    private function runSendingMessage(UserDTO $userDto): void
    {
        $registrationMessageDto = RegistrationMessageDto::createFromUserDto($userDto);
        try {
            $this->registrationMessage->send($registrationMessageDto);
        } catch (\Throwable $exception) {
            $this->storeLogger->error($exception->getMessage());
            throw new SystemException("Системная ошибка");
        }
    }

    public function register(Uuid $userId): void
    {
        $this->runConfirmUser($userId);
    }

    private function runConfirmUser(Uuid $userId): void
    {
        try {
            $this->confirmingUser->confirm($userId);
        } catch (\Throwable $exception) {
            $this->storeLogger->error($exception->getMessage());
            throw new SystemException;
        }
    }

    private function getUserFromUserFactory(CreateUserDto $dto): User
    {
        try {
            $user = $this->userFactory->create($dto);
        } catch (DomainException $exception) {
            throw new CreateUserException;
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