<?php

namespace App\Domain\User;

use App\Domain\Exception\SystemException;
use App\Domain\User\Exception\UserAuthException;
use App\Domain\User\Store\DTO\UserAuthorizationDto;
use App\Domain\User\Store\DTO\UserDTO;
use App\Domain\User\Store\GetUserInterface;
use App\Domain\User\Store\UserAuthStoreInterface;

class UserAuthInspector
{
    public function __construct(
        private UserAuthStoreInterface $userAuthStore,
        private GetUserInterface $getUser,
    )
    {}


    public function auth(UserAuthorizationDto $userAuthorizationDto): UserDTO
    {
        if (!$this->isStoreAuthCompleted($userAuthorizationDto)) {
            throw new UserAuthException;
        }
        return $this->getUserDto($userAuthorizationDto);
    }

    private function isStoreAuthCompleted(UserAuthorizationDto $userAuthorizationDto): bool
    {
        try {
            $isAuthCompleted = $this->userAuthStore->isAuthCompleted($userAuthorizationDto);
        } catch (\Throwable $exception) {
            // TODO: Добавить логер
            throw new SystemException;
        }
        return $isAuthCompleted;
    }

    private function getUserDto(UserAuthorizationDto $userAuthorizationDto): UserDTO
    {
        try {
            $userDto = $this->getUser->getByLogin($userAuthorizationDto->login);
        } catch (\Throwable $exception) {
            // TODO: Добавить логер
            throw new SystemException;
        }
        return $userDto;
    }
}