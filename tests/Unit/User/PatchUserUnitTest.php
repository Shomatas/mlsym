<?php

namespace App\Tests\Unit\User;

use App\Domain\Exception\SystemException;
use App\Domain\User\Exception\PatchValidationException;
use App\Domain\User\Store\DTO\PatchUserDto;
use App\Domain\User\Store\PatchUserInterface;
use App\Domain\User\UserPatcher;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PatchUserUnitTest extends KernelTestCase
{
    private ValidatorInterface $validator;
    private ConstraintViolationListInterface $constraintViolationList;
    private PatchUserInterface $patchUser;
    private UserPatcher $userPatcher;
    private PatchUserDto $patchUserDto;
    public function setUp(): void
    {
        $this->constraintViolationList = $this->createMock(ConstraintViolationListInterface::class);
        $this->validator = $this->createMock(ValidatorInterface::class);
        $this->patchUser = $this->createMock(PatchUserInterface::class);
        $this->userPatcher = new UserPatcher(
            $this->patchUser,
            $this->validator,
            $this->createStub(LoggerInterface::class)
        );
        $this->patchUserDto = new PatchUserDto;
    }

    /**
     * @test
     */
    public function patch(): void
    {
        $this->expectNotToPerformAssertions();
        $this->constraintViolationList->method('count')->willReturn(0);
        $this->validator->method('validate')->willReturn($this->constraintViolationList);
        $this->userPatcher->patch($this->patchUserDto);
    }

    /**
     * @test
     */
    public function patchWithFailedValidation(): void
    {
        $this->expectException(PatchValidationException::class);
        $this->constraintViolationList->method('count')->willReturn(1);
        $this->validator->method('validate')->willReturn($this->constraintViolationList);
        $this->userPatcher->patch($this->patchUserDto);
    }

    /**
     * @test
     */
    public function patchWithFailedPatchUserInterface(): void
    {
        $this->expectException(SystemException::class);
        $this->patchUser->method('patch')->willThrowException(new \Exception);
        $this->userPatcher->patch($this->patchUserDto);
    }

    /**
     * @test
     */
    public function countCalledMethods(): void
    {
        $this->constraintViolationList->expects(self::once())->method('count');
        $this->validator
            ->expects(self::once())
            ->method('validate')
            ->willReturn($this->constraintViolationList);
        $this->patchUser->expects(self::once())->method('patch');
        $this->userPatcher->patch($this->patchUserDto);
    }
}