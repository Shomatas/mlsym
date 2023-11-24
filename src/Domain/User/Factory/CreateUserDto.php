<?php

namespace App\Domain\User\Factory;

use App\Domain\Address\Address;
use App\Domain\User\Profile;
use App\Domain\User\Store\DTO\UserDTO;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateUserDto
{
    public function __construct(
        #[Assert\NotBlank]
        public string $login = "",
        #[Assert\NotBlank]
        public string $password = "",
        #[Assert\NotBlank]
        public ?Profile $profile = null,
        #[Assert\NotBlank]
        public ?Address $address = null,
        #[Assert\NotBlank]
        #[Assert\Email]
        public string $email = "",
        public ?string $phone = null,
        public ?string $pathTempFileAvatar = "",
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
            new Profile(
                $data["profile"]["firstname"],
                $data["profile"]["lastname"],
                $data["profile"]["age"],
                $data["profile"]["avatar"]
            ),
            new Address(
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