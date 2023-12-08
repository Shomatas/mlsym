<?php

namespace App\Domain\User\Exception;

use App\Domain\Exception\DomainException;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Throwable;

class UserValidationException extends DomainException
{
    public function __construct(
        private ?ConstraintViolationListInterface $violationList = null,
        string                                   $message = "",
        int                                      $code = 0,
        ?Throwable                               $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
    }

    public function getViolationList(): ConstraintViolationListInterface
    {
        return $this->violationList;
    }
}