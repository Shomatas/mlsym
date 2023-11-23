<?php

namespace App\Store\User;

use App\Domain\Address\Address;
use App\Domain\User\Avatar;
use App\Domain\User\Profile;
use App\Domain\User\Store\DTO\UserCollectionDTO;
use App\Domain\User\Store\DTO\UserDTO;
use App\Domain\User\Store\GetUserInterface;
use App\Domain\User\Store\GetUserTestInterface;
use App\Entity\Users;
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
            new Address($userData->getCountry(), $userData->getCity(), $userData->getStreet(), $userData->getHouseNumber()),
            $userData->getEmail(),
            $userData->getPhone(),
        );
    }

    public function getAll(): UserCollectionDTO
    {
        $collection = $this->entityManager->getRepository(Users::class)->findAll();
        $data = $this->userEntityCollectionMapper->mapToArray($collection);
        return $this->userCollectionDtoMapper->mapFromArray($data);
    }
}