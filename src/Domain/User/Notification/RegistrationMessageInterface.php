<?php

namespace App\Domain\User\Notification;

use App\Domain\User\Notification\DTO\RegistrationMessageDto;

interface RegistrationMessageInterface
{
    public function send(RegistrationMessageDto $registrationMessageDto): void;
}