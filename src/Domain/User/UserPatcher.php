<?php

namespace App\Domain\User;

use App\Domain\Exception\SystemException;
use App\Domain\User\Exception\PatchValidationException;
use App\Domain\User\Store\DTO\PatchUserDto;
use App\Domain\User\Store\PatchUserInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserPatcher
{
    public function __construct(
        private readonly PatchUserInterface $patchUser,
        private readonly ValidatorInterface $validator,
        private readonly LoggerInterface $storeLogger,
    )
    {
    }

    public function patch(PatchUserDto $patchUserDto): void
    {
        $this->validateAndThrowExistingErrors($patchUserDto);
        $this->runPatchUser($patchUserDto);
    }

    private function validateAndThrowExistingErrors(PatchUserDto $patchUserDto): void
    {
        $result = $this->getViolationListFromValidation($patchUserDto);
        if ($result->count() > 0) {
            throw new PatchValidationException($result);
        }
    }

    private function getViolationListFromValidation(PatchUserDto $patchUserDto): ConstraintViolationListInterface
    {
        return $this->validator->validate($patchUserDto);
    }

    private function runPatchUser(PatchUserDto $patchUserDto): void
    {
        try {
            $this->patchUser->patch($patchUserDto);
        } catch (\Throwable $exception) {
            $this->storeLogger->error($exception->getMessage());
            throw new SystemException;
        }
    }
}