<?php

namespace App\Notification\User;

use App\Domain\User\Notification\DTO\RegistrationMessageDto;
use App\Domain\User\Notification\RegistrationMessageInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class RegistrationMessage implements RegistrationMessageInterface
{
    public function __construct(
        private MailerInterface $mailer,
    ) {}
    public function send(RegistrationMessageDto $registrationMessageDto): void
    {
        $mail = $this->prepareMessage($registrationMessageDto);
        $this->mailer->send($mail);
    }

    private function prepareMessage(RegistrationMessageDto $registrationMessageDto): Email
    {
        return (new Email())
            ->from("support@lsym.ru")
            ->to($registrationMessageDto->email)
            ->text("http://localhost:8000/users/registration/{$registrationMessageDto->id}");
    }
}