<?php

namespace App\Executor\Controller\User\Exception;

class ValidationException extends \RuntimeException
{
    protected $message = "Ошибка валидации запроса";
}