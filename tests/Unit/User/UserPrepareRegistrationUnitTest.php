<?php

namespace App\Tests\Unit\User;

use App\Domain\Address\Factory\CreateAddressDto;
use App\Domain\Exception\DomainException;
use App\Domain\Exception\SystemException;
use App\Domain\User\Exception\CreateUserException;
use App\Domain\User\Factory\UserFactory;
use App\Domain\User\Notification\RegistrationMessageInterface;
use App\Domain\User\Store\DTO\AddressRegisterDto;
use App\Domain\User\Store\DTO\ProfileRegisterDto;
use App\Domain\User\Store\DTO\UserRegisterDTO;
use App\Domain\User\Store\SaveUserInterface;
use App\Domain\User\Store\TemporarySaveUserDtoInterface;
use App\Domain\User\User;
use App\Domain\User\UserRegistration;
use Doctrine\DBAL\Exception;
use PHPUnit\Event\Code\Throwable;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserPrepareRegistrationUnitTest extends KernelTestCase
{
    public SaveUserInterface $saveUser;
    public UserFactory $userFactory;
    public LoggerInterface $logger;
    public LoggerInterface $storeLogger;
    public TemporarySaveUserDtoInterface $temporarySaveUserDto;
    public RegistrationMessageInterface $registrationMessage;
    public UserRegisterDTO $registerDtoStub;
    public User $user;

    public function setUp(): void
    {
        $this->saveUser = $this->createStub(SaveUserInterface::class);
        $this->userFactory = $this->createMock(UserFactory::class);
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->storeLogger = $this->createMock(LoggerInterface::class);
        $this->temporarySaveUserDto = $this->createMock(TemporarySaveUserDtoInterface::class);
        $this->registrationMessage = $this->createMock(RegistrationMessageInterface::class);
        $this->user = $this->createStub(User::class);
        $this->registerDtoStub = new UserRegisterDTO(
            'paff',
            '1234',
            new ProfileRegisterDto(
                'ivan',
                'komarov',
                22,
            ),
            new AddressRegisterDto(
                'Russia',
                'Kaluga',
                'Suvorova',
                '121a',
            ),
            'vano2001komarov@mail.ru',
        );
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
    public function prepareRegistration(): void
    {
        $this->expectNotToPerformAssertions();
        $userRegistration = $this->createUserRegistration();
        $userRegistration->prepareRegistration(
            $this->registerDtoStub,
        );
    }

    /**
     * @test
     */
    public function prepareRegistrationWithUserFactoryCreateUserException(): void
    {
        $this->expectException(CreateUserException::class);
        $this->userFactory->method('create')
            ->willThrowException(new DomainException);
        $userRegistration = $this->createUserRegistration();
        $userRegistration->prepareRegistration($this->registerDtoStub);
    }

    /**
     * @test
     */
    public function prepareRegistrationWithUserFactorySystemException(): void
    {
        $this->expectException(SystemException::class);
        $this->userFactory->method('create')
            ->willThrowException(new \Exception);
        $userRegistration = $this->createUserRegistration();
        $userRegistration->prepareRegistration($this->registerDtoStub);
    }

    /**
     * @test
     */
    public function prepareRegistrationWithSaveTemporarySystemException(): void
    {
        $this->expectException(SystemException::class);
        $this->userFactory->method('create')
            ->willReturn($this->user);
        $this->temporarySaveUserDto->method('save')
            ->willThrowException(new Exception);
        $userRegistration = $this->createUserRegistration();
        $userRegistration->prepareRegistration($this->registerDtoStub);
    }

    /**
     * @test
     */
    public function prepareRegistrationWithRegistrationMessageSystemException(): void
    {
        $this->expectException(SystemException::class);
        $this->userFactory->method('create')
            ->willReturn($this->user);
        $this->registrationMessage->method('send')
            ->willThrowException(new Exception);
        $userRegistration = $this->createUserRegistration();
        $userRegistration->prepareRegistration($this->registerDtoStub);
    }

    /**
     * @test
     */
    public function countCalledMethods(): void
    {
        $this->userFactory->expects(self::once())
            ->method('create')
            ->willReturn($this->user);
        $this->temporarySaveUserDto->expects(self::once())
            ->method('save');
        $this->registrationMessage->expects(self::once())
            ->method('send');
        $userRegistration = $this->createUserRegistration();
        $userRegistration->prepareRegistration(
            $this->registerDtoStub
        );
    }
}