<?php

namespace App\Domain\User\Exception;

class UserAuthException extends \DomainException
{
    protected $message = "Ошибка авторизации пользователя";
}