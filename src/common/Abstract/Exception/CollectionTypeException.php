<?php

namespace App\common\Abstract\Exception;

class CollectionTypeException extends \RuntimeException
{
    protected $message = "Ошибка с типом коллекции";
}