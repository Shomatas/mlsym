<?php

namespace App\Entity;

use App\Domain\User\Store\DTO\UserDTO;
use App\Repository\UsersRepository;
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
    private ?string $pathToAvatar = null;

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

    public function __construct(
        ?Uuid $id,
        ?string $login,
        ?string $password,
        ?string $firstname,
        ?string $lastname,
        ?int $age,
        ?string $pathToAvatar,
        ?string $email,
        ?string $phone,
        ?string $country,
        ?string $city,
        ?string $street,
        ?string $houseNumber
    )
    {
        $this->id = $id;
        $this->login = $login;
        $this->password = $password;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->age = $age;
        $this->pathToAvatar = $pathToAvatar;
        $this->email = $email;
        $this->phone = $phone;
        $this->country = $country;
        $this->city = $city;
        $this->street = $street;
        $this->houseNumber = $houseNumber;
    }


    public static function createFromUserDTO(UserDTO $userDTO): self
    {
        return new Users(
            $userDTO->id,
            $userDTO->login,
            $userDTO->password,
            $userDTO->profile->getFirstName(),
            $userDTO->profile->getLastName(),
            $userDTO->profile->getAge(),
            $userDTO->profile->getAvatar()->getPathToFile(),
            $userDTO->email,
            $userDTO->phone,
            $userDTO->address->getCountry(),
            $userDTO->address->getCity(),
            $userDTO->address->getStreet(),
            $userDTO->address->getHouseNumber(),
        );
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

    public function getPathToAvatar(): ?string
    {
        return $this->pathToAvatar;
    }

    public function setPathToAvatar(string $pathToAvatar): static
    {
        $this->pathToAvatar = $pathToAvatar;

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
