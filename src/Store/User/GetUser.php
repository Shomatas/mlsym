<?php

namespace App\Store\User;

use App\Domain\Address\Address;
use App\Domain\Address\Store\DTO\AddressDto;
use App\Domain\User\Avatar;
use App\Domain\User\Profile;
use App\Domain\User\Store\DTO\Collection\UserDtoCollection;
use App\Domain\User\Store\DTO\UserDTO;
use App\Domain\User\Store\GetUserInterface;
use App\Domain\User\Store\GetUserTestInterface;
use App\Store\Connection\Entity\Users;
use App\Store\Connection\UserEntityCollectionMapper;
use Doctrine\ORM\EntityManagerInterface;
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
            new Profile(
                $userData->getFirstname(),
                $userData->getLastname(),
                $userData->getAge(),
                new Avatar($userData->getPathToAvatar(), $userData->getAvatarMimeType())
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
}