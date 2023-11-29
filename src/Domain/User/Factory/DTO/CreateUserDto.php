<?php

namespace App\Domain\User\Factory\DTO;

use App\Domain\Address\Address;
use App\Domain\Address\Factory\CreateAddressDto;
use App\Domain\User\Profile;
use App\Domain\User\Store\DTO\ProfileRegisterDto;
use App\common\Validator as CustomAssert;
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
        #[Assert\Email]
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

    public static function createFromArray(array $data): self
    {
        return new CreateUserDto(
            $data["login"],
            $data["password"],
            new CreateProfileDto(
                $data["profile"]["firstname"],
                $data["profile"]["lastname"],
                $data["profile"]["age"],
            ),
            new CreateAddressDto(
                $data["address"]["country"],
                $data["address"]["city"],
                $data["address"]["street"],
                $data["address"]["house_number"],
            ),
            $data["email"],
            $data["phone"],
        );
    }

    public static function createFromJson(string $jsonData): self
    {
        return self::createFromArray(json_decode($jsonData, true));
    }
}