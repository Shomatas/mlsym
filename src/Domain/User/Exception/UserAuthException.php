<?php

namespace App\Domain\User\Exception;

use App\Domain\Exception\DomainException;

class UserAuthException extends DomainException
{
    protected $message = "Ошибка авторизации пользователя";
}