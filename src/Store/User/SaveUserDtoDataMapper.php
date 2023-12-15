<?php

namespace App\Store\User;

use App\Domain\Address\Store\DTO\AddressDto;
use App\Domain\User\Store\DTO\ProfileDto;
use App\Domain\User\Store\DTO\SaveUserDto;
use App\Domain\User\Store\DTO\UserDTO;
use App\Domain\User\Store\SaveUserDtoDataMapperInterface;
use Symfony\Component\Uid\Uuid;

class SaveUserDtoDataMapper implements SaveUserDtoDataMapperInterface
{

    public function mapToArray(SaveUserDto $saveUserDto): array
    {
        return [
            "id" => $saveUserDto->userDTO->id,
            "login" => $saveUserDto->userDTO->login,
            "password" => $saveUserDto->userDTO->password,
            "firstname" => $saveUserDto->userDTO->profile->firstname,
            "lastname" => $saveUserDto->userDTO->profile->lastname,
            "age" => $saveUserDto->userDTO->profile->age,
            "country" => $saveUserDto->userDTO->address->country,
            "city" => $saveUserDto->userDTO->address->city,
            "street" => $saveUserDto->userDTO->address->street,
            "house_number" => $saveUserDto->userDTO->address->houseNumber,
            "email" => $saveUserDto->userDTO->email,
            "phone" => $saveUserDto->userDTO->phone,
            "mime_type" => $saveUserDto->mimeType,
            "temp_url_avatar" => $saveUserDto->tempUrlAvatar,
        ];
    }

    public function mapToJson(SaveUserDto $saveUserDto): string
    {
        return json_encode($this->mapToArray($saveUserDto), JSON_UNESCAPED_UNICODE);
    }

    public function mapFromArray(array $data): SaveUserDto
    {
        return new SaveUserDto(
            new UserDTO(
                Uuid::fromString($data["id"]),
                $data["login"],
                $data["password"],
                new ProfileDto(
                    $data["firstname"],
                    $data["lastname"],
                    $data["age"],
                ),
                new AddressDto(
                    $data["country"],
                    $data["city"],
                    $data["street"],
                    $data["house_number"],
                ),
                $data["email"],
                $data["phone"],
            ),
            $data["temp_url_avatar"],
            $data["mime_type"],
        );
    }

    public function mapFromJson(string $data): SaveUserDto
    {
        return $this->mapFromArray(json_decode($data, true));
    }
}