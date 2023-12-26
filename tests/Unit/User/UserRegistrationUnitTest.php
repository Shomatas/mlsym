<?php

namespace App\Tests\Unit\User;

use App\Domain\Exception\DomainException;
use App\Domain\User\Factory\UserFactory;
use App\Domain\User\Notification\RegistrationMessageInterface;
use App\Domain\User\Store\ConfirmingUserInterface;
use App\Domain\User\Store\DTO\SaveUserDto;
use App\Domain\User\Store\DTO\UserRegisterDTO;
use App\Domain\User\Store\SaveUserInterface;
use App\Domain\User\Store\TemporarySaveUserDtoInterface;
use App\Domain\User\UserRegistration;
use Doctrine\DBAL\Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Uid\Uuid;

class UserRegistrationUnitTest extends KernelTestCase
{
    public SaveUserInterface $saveUser;
    public UserFactory $userFactory;
    public LoggerInterface $userFactoryLogger;
    public LoggerInterface $storeLogger;
    public ConfirmingUserInterface $confirmingUser;
    public RegistrationMessageInterface $registrationMessage;
    public UserRegisterDTO $registerDtoStub;

    public function setUp(): void
    {
        $this->saveUser = $this->createStub(SaveUserInterface::class);
        $this->userFactory = $this->createMock(UserFactory::class);
        $this->userFactoryLogger = $this->createMock(LoggerInterface::class);
        $this->storeLogger = $this->createMock(LoggerInterface::class);
        $this->confirmingUser = $this->createMock(ConfirmingUserInterface::class);
        $this->registrationMessage = $this->createMock(RegistrationMessageInterface::class);
    }


    public function createUserRegistration(): UserRegistration
    {
        return new UserRegistration(
            $this->saveUser,
            $this->userFactory,
            $this->storeLogger,
            $this->userFactoryLogger,
            $this->registrationMessage,
            $this->confirmingUser,
        );
    }

    /**
     * @test
     */
    public function register(): void
    {
        $this->expectNotToPerformAssertions();
        $userRegistration = $this->createUserRegistration();
        $userRegistration->register(Uuid::v1());
    }

    /**
     * @test
     */
    public function registerWithFailedConfirmed(): void
    {
        $this->expectException(DomainException::class);
        $this->confirmingUser->method('confirm')
            ->willThrowException(new \Exception);
        $userRegistration = $this->createUserRegistration();
        $userRegistration->register(Uuid::v1());
    }

    /**
     * @test
     */
    public function countCalledMethods(): void
    {
        $this->confirmingUser->expects(self::once())
            ->method('confirm');
        $userRegistration = $this->createUserRegistration();
        $userRegistration->register(Uuid::v1());
    }
}