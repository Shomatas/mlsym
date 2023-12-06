<?php

namespace App\Domain\User\Factory\DTO;

use App\Domain\Address\Factory\CreateAddressDto;
use App\common\Validator as CustomAssert;
use App\Domain\User\Store\DTO\UserRegisterDTO;
use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateUserDto
{
    public function __construct(
        #[Assert\NotBlank]
        public string $login = "",
        #[Assert\NotBlank]
        public string $password = "",
        #[Assert\NotBlank]
        public ?CreateProfileDto $profile = null,
        #[Assert\NotBlank]
        public ?CreateAddressDto $address = null,
        #[Assert\NotBlank]
        #[Assert\Email(message: '{{ value }} - невалидный email адресс')]
        public string $email = "",
        #[CustomAssert\Phone]
        public ?string $phone = null,
        #[Assert\NotBlank]
        public ?string $pathTempFileAvatar = "",
        #[Assert\NotBlank]
        #[Assert\Regex("/^image\/(jpeg|png|gif)$/")]
        public ?string $avatarMimeType = "",
    )
    {

    }

    public static function createFromUserRegisterDto(UserRegisterDTO $userRegisterDTO): self
    {
        return new CreateUserDto(
            $userRegisterDTO->login,
            $userRegisterDTO->password,
            new CreateProfileDto(
                $userRegisterDTO->profile->firstname,
                $userRegisterDTO->profile->lastname,
                $userRegisterDTO->profile->age,
            ),
            new CreateAddressDto(
                $userRegisterDTO->address->country,
                $userRegisterDTO->address->city,
                $userRegisterDTO->address->street,
                $userRegisterDTO->address->houseNumber,
            ),
            $userRegisterDTO->email,
            $userRegisterDTO->phone,
            $userRegisterDTO->tempPathAvatar,
            $userRegisterDTO->avatarMimeType,
        );
    }

}