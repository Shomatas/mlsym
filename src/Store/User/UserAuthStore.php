<?php

namespace App\Store\User;

use App\Domain\User\Store\DTO\UserAuthorizationDto;
use App\Domain\User\Store\GetUserInterface;
use App\Domain\User\Store\UserAuthStoreInterface;
use App\Store\Connection\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;

class UserAuthStore implements UserAuthStoreInterface
{
    public function __construct(
        public EntityManagerInterface $entityManager,
    )
    {
    }

    public function isAuthCompleted(UserAuthorizationDto $userAuthorizationDto): bool
    {
        $userData = $this->entityManager->getRepository(Users::class)->findOneBy([
            "login" => $userAuthorizationDto->login,
        ]);



        return !is_null($userData) && ($userData->getPassword() === $userAuthorizationDto->password);
    }
}