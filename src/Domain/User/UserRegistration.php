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

class UserRegistration
{
    public function __construct(
        private SaveUserInterface $userSaver,
        private UserFactory $userFactory,
        private LoggerInterface $storeLogger,
        private LoggerInterface $userFactoryLogger,
        private TemporarySaveUserDtoInterface $temporarySaveUserDto,
        private RegistrationMessageInterface $registrationMessage,
    ) {}

    public function prepareRegistration(UserRegisterDTO $dto)
    {
        $createUserDto = CreateUserDto::createFromUserRegisterDto($dto);
        $user = $this->getUserFromUserFactory($createUserDto);
        $userDto = UserDTO::createFromUser($user);
        $saveTempUserDto = new SaveTempUserDto($userDto, $createUserDto);
        $this->runSaveTemporaryUserDto($saveTempUserDto);
        $this->runSendingMessage($userDto);
    }

    private function runSaveTemporaryUserDto(SaveTempUserDto $saveTempUserDto): void
    {
        $saveUserDto = new SaveUserDto(
            $saveTempUserDto->userDto,
            $saveTempUserDto->createUserDto->pathTempFileAvatar,
            $saveTempUserDto->createUserDto->avatarMimeType
        );
        try {
            $this->temporarySaveUserDto->save($saveUserDto);
        } catch (\Throwable $exception) {
            $this->storeLogger->error($exception->getMessage());
            throw new SystemException("Системная ошибка");
        }
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

    public function register(string $userId): void
    {
        $saveUserDto = $this->getSaveUserDtoFromTemporarySaveUserDto($userId);
        $this->runSaveUser($saveUserDto);
    }

    private function getSaveUserDtoFromTemporarySaveUserDto(string $userId): SaveUserDto
    {
        try {
            $saveUserDto = $this->temporarySaveUserDto->pop($userId);
        } catch (\Throwable $exception) {
            $this->storeLogger->error($exception->getMessage());
        }
        return $saveUserDto;
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