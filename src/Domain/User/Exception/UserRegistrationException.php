<?php

namespace App\Domain\User\Exception;

use App\Domain\Exception\DomainException;
use http\Message;

class UserRegistrationException extends DomainException
{
    protected $message = "Во время регистрации произошла ошибка";
}