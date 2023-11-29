<?php

namespace App\Domain\User\Store\DTO;

use App\Domain\Address\Address;
use App\Domain\User\Profile;

readonly class UserRegisterDTO
{

    public function __construct(
        public string $login = "",
        public string $password = "",
        public ?ProfileRegisterDto $profile = null,
        public ?AddressRegisterDto $address = null,
        public string $email = "",
        public ?string $phone = null,
        public string $tempPathAvatar = "",
        public string $avatarMimeType = "",
    )
    {

    }
}