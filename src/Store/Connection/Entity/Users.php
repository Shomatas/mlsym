<?php

namespace App\Store\Connection\Entity;

use App\Domain\User\Store\DTO\SaveUserDto;
use App\Domain\User\Store\DTO\UserDTO;
use App\Store\Connection\Repository\UsersRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    private ?Uuid $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $login = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $password = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $firstname = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $lastname = null;

    #[ORM\Column]
    private ?int $age = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $email = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $country = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $city = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $street = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $houseNumber = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $avatarMimeType = "null";

    #[ORM\Column(type: Types::BOOLEAN)]
    private ?bool $isConfirmed = null;


    public function __construct(
        ?Uuid $id = null,
        ?string $login = null,
        ?string $password = null,
        ?string $firstname = null,
        ?string $lastname = null,
        ?int $age = null,
        ?string $email = null,
        ?string $phone = null,
        ?string $country = null,
        ?string $city = null,
        ?string $street = null,
        ?string $houseNumber = null,
        ?string $avatarMimeType = null,
        ?bool $isConfirmed = null,
    )
    {
        $this->id = $id;
        $this->login = $login;
        $this->password = $password;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->age = $age;
        $this->email = $email;
        $this->phone = $phone;
        $this->country = $country;
        $this->city = $city;
        $this->street = $street;
        $this->houseNumber = $houseNumber;
        $this->avatarMimeType = $avatarMimeType;
        $this->isConfirmed = $isConfirmed;
    }

    public static function createFromSaveUserDto(SaveUserDto $dto): Users
    {
        return new Users(
            $dto->userDTO->id,
            $dto->userDTO->login,
            $dto->userDTO->password,
            $dto->userDTO->profile->firstname,
            $dto->userDTO->profile->lastname,
            $dto->userDTO->profile->age,
            $dto->userDTO->email,
            $dto->userDTO->phone,
            $dto->userDTO->address->country,
            $dto->userDTO->address->city,
            $dto->userDTO->address->street,
            $dto->userDTO->address->houseNumber,
            $dto->mimeType,
            $dto->userDTO->isConfirmed,
        );
    }

    public function isConfirmed(): ?bool
    {
        return $this->isConfirmed;
    }

    public function setIsConfirmed(bool $isConfirmed): static
    {
        $this->isConfirmed = $isConfirmed;

        return $this;
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): static
    {
        $this->login = $login;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): static
    {
        $this->street = $street;

        return $this;
    }

    public function getHouseNumber(): ?string
    {
        return $this->houseNumber;
    }

    public function setHouseNumber(string $houseNumber): static
    {
        $this->houseNumber = $houseNumber;

        return $this;
    }

    public function getAvatarMimeType(): ?string
    {
        return $this->avatarMimeType;
    }

    public function setAvatarMimeType(string $avatarMimeType): static
    {
        $this->avatarMimeType = $avatarMimeType;

        return $this;
    }
}
