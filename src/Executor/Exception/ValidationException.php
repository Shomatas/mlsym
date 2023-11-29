<?php

namespace App\Executor\Exception;

class ValidationException extends \RuntimeException
{
    protected $message = "Ошибка валидации запроса";
}