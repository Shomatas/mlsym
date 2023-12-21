<?php

namespace App\Domain\User\Store;

use App\Domain\User\Store\DTO\UserAuthorizationDto;

interface UserAuthStoreInterface
{
    public function isAuthCompleted(UserAuthorizationDto $userAuthorizationDto): bool;
}