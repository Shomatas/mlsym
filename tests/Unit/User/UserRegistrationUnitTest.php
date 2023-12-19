<?php

namespace App\Tests\Unit\User;

use App\Domain\Exception\DomainException;
use App\Domain\User\Factory\UserFactory;
use App\Domain\User\Notification\RegistrationMessageInterface;
use App\Domain\User\Store\DTO\SaveUserDto;
use App\Domain\User\Store\SaveUserInterface;
use App\Domain\User\Store\TemporarySaveUserDtoInterface;
use App\Domain\User\UserRegistration;
use Doctrine\DBAL\Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRegistrationUnitTest extends KernelTestCase
{
    const USER_ID_STUB = "1";
    public SaveUserInterface $saveUser;
    public UserFactory $userFactory;
    public LoggerInterface $logger;
    public LoggerInterface $storeLogger;
    public TemporarySaveUserDtoInterface $temporarySaveUserDto;
    public RegistrationMessageInterface $registrationMessage;

    public function setUp(): void
    {
        $this->saveUser = $this->createMock(SaveUserInterface::class);
        $this->userFactory = $this->createStub(UserFactory::class);
        $this->logger = $this->createStub(LoggerInterface::class);
        $this->storeLogger = $this->createStub(LoggerInterface::class);
        $this->temporarySaveUserDto = $this->createMock(TemporarySaveUserDtoInterface::class);
        $this->registrationMessage = $this->createStub(RegistrationMessageInterface::class);
    }

    public function createUserRegistration(): UserRegistration
    {
        return new UserRegistration(
            $this->saveUser,
            $this->userFactory,
            $this->logger,
            $this->storeLogger,
            $this->temporarySaveUserDto,
            $this->registrationMessage,
        );
    }

    /**
     * @test
     */
    public function register(): void
    {
        $this->expectNotToPerformAssertions();
        $this->temporarySaveUserDto->method('pop')->willReturn(new SaveUserDto);
        $userRegistration = $this->createUserRegistration();
        $userRegistration->register(self::USER_ID_STUB);
    }

    /**
     * @test
     */
    public function registerWithFailedTemporaryStore(): void
    {
        $this->expectException(DomainException::class);
        $this->temporarySaveUserDto->method('pop')
            ->willThrowException(new \Exception);
        $userRegistration = $this->createUserRegistration();
        $userRegistration->register(self::USER_ID_STUB);
    }

    /**
     * @test
     */
    public function registerWithFailedSaveUser(): void
    {
        $this->expectException(DomainException::class);
        $this->temporarySaveUserDto->method('pop')
            ->willReturn(new SaveUserDto);
        $this->saveUser->method('save')
            ->willThrowException(new Exception);
        $userRegistration = $this->createUserRegistration();
        $userRegistration->register(self::USER_ID_STUB);
    }

    /**
     * @test
     */
    public function countCalledMethods(): void
    {
        $this->temporarySaveUserDto->expects(self::once())
            ->method('pop')
            ->willReturn(new SaveUserDto);
        $this->saveUser->expects(self::once())
            ->method('save');
        $userRegistration = $this->createUserRegistration();
        $userRegistration->register(self::USER_ID_STUB);
    }
}