<?php

namespace App\Domain\User\Exception;

use http\Message;

class UserRegistrationException extends \RuntimeException
{
    protected $message = "Во время регистрации произошла ошибка";
}