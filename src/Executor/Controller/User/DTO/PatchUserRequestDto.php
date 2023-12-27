<?php

namespace App\Executor\Controller\User\DTO;

use App\Domain\User\Store\DTO\PatchProfileDto;

readonly class PatchUserRequestDto
{
    public function __construct(
        public mixed                   $login = null,
        public mixed                   $password = null,
        public ?PatchProfileRequestDto $patchProfileRequestDto = null,
        public ?PatchAddressRequestDto $patchAddressRequestDto = null,
        public mixed                   $email = null,
        public mixed                   $phone = null,
    )
    {
    }
}