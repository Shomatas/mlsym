<?php

namespace App\Domain\User\Store\DTO;

use App\Domain\Address\Store\DTO\PatchAddressDto;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;
use App\common\Validator as CustomAssert;

readonly class PatchUserDto
{
    public function __construct(
        #[Assert\NotBlank]
        public ?Uuid $id = null,
        #[Assert\Length(min: 1)]
        public ?string $login = null,
        #[Assert\Length(min: 1)]
        public ?string $password = null,
        public ?PatchProfileDto $profileDto = null,
        public ?PatchAddressDto $addressDto = null,
        #[Assert\Email]
        public ?string $email = null,
        #[CustomAssert\Phone]
        public ?string $phone = null,
    )
    {
    }
}