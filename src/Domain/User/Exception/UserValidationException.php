<?php

namespace App\Domain\User\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class UserValidationException extends \RuntimeException
{
    public function __construct(
        protected ?ConstraintViolationListInterface $violationList = null,
        string $message = "",
        int $code = 0,
        ?\Throwable $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
    }

    public function getViolationList(): ConstraintViolationListInterface{
        return $this->violationList;
    }
}