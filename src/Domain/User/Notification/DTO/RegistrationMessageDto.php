<?php

namespace App\Domain\User\Notification\DTO;

use App\Domain\User\Store\DTO\UserDTO;
use Symfony\Component\Uid\Uuid;

readonly class RegistrationMessageDto
{
    public function __construct(
        public ?Uuid $id = null,
        public string $email = "",
    ) {}

    public static function createFromUserDto(UserDTO $userDTO): self
    {
        return new RegistrationMessageDto(
            $userDTO->id,
            $userDTO->email,
        );
    }
}