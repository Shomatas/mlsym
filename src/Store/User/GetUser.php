<?php

namespace App\Store\User;

use App\Domain\Address\Address;
use App\Domain\Address\Store\DTO\AddressDto;
use App\Domain\User\Avatar;
use App\Domain\User\Profile;
use App\Domain\User\Store\DTO\AvatarDto;
use App\Domain\User\Store\DTO\Collection\UserDtoCollection;
use App\Domain\User\Store\DTO\ProfileDto;
use App\Domain\User\Store\DTO\UserDTO;
use App\Domain\User\Store\GetUserInterface;
use App\Domain\User\Store\GetUserTestInterface;
use App\Store\Connection\Entity\Users;
use App\Store\Connection\UserEntityCollectionMapper;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Component\Uid\Uuid;

class GetUser implements GetUserTestInterface, GetUserInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserEntityCollectionMapper $userEntityCollectionMapper,
        private UserCollectionDtoMapper $userCollectionDtoMapper,
    )
    {}
    public function get(Uuid $id): UserDTO
    {
        $userData = $this->entityManager->getRepository(Users::class)->find($id);

        return new UserDTO(
            $userData->getId(),
            $userData->getLogin(),
            $userData->getPassword(),
            new ProfileDto(
                $userData->getFirstname(),
                $userData->getLastname(),
                $userData->getAge(),
                new AvatarDto(),
            ),
            new AddressDto($userData->getCountry(), $userData->getCity(), $userData->getStreet(), $userData->getHouseNumber()),
            $userData->getEmail(),
            $userData->getPhone(),
        );
    }

    public function getByLogin(string $login): UserDTO
    {
        $userData = $this->entityManager->getRepository(Users::class)->findOneBy([
            "login" => $login,
        ]);

        return new UserDTO(
            $userData->getId(),
            $userData->getLogin(),
            $userData->getPassword(),
            new ProfileDto(
                $userData->getFirstname(),
                $userData->getLastname(),
                $userData->getAge(),
                new AvatarDto(),
            ),
            new AddressDto($userData->getCountry(), $userData->getCity(), $userData->getStreet(), $userData->getHouseNumber()),
            $userData->getEmail(),
            $userData->getPhone(),
        );
    }

    public function getAll(): UserDtoCollection
    {
        $collection = $this->entityManager->getRepository(Users::class)->findAll();
        $data = $this->userEntityCollectionMapper->mapToArray($collection);
        return $this->userCollectionDtoMapper->mapFromArray($data);
    }

    public function getLast(): UserDTO
    {
        $collection = $this->entityManager->getRepository(Users::class)->findAll();
        $data = $this->userEntityCollectionMapper->mapToArray($collection);
        $collection = $this->userCollectionDtoMapper->mapFromArray($data);
        return $collection[$collection->count() - 1];
    }

    public function getDataSize(): int
    {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult("len", "size");
        $query = $this->entityManager->createNativeQuery('SELECT count(id) as len FROM users', $rsm);
        return $query->getResult()[0]["size"];
    }
}