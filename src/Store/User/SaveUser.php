<?php

namespace App\Store\User;

use App\Domain\User\Store\DTO\SaveUserDto;
use App\Domain\User\Store\SaveUserInterface;
use App\Store\Connection\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;

class SaveUser implements SaveUserInterface
{

    public function __construct(
        private EntityManagerInterface $entityManager,
        private Filesystem $filesystem,
    )
    {
    }

    public function save(SaveUserDto $dto): void
    {
        $this->entityManager->beginTransaction();

        $productEntity = new Users(
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
        );
        $this->entityManager->persist($productEntity);
        $this->entityManager->flush();

        $type = explode('/', $dto->mimeType)[1];
        $this->filesystem->copy($dto->tempUrlAvatar, "/app/public/images/{$dto->userDTO->id}.{$type}");

        $this->entityManager->commit();
    }
}