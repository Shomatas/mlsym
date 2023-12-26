<?php

namespace App\Store\User;

use App\Domain\User\Store\DTO\SaveUserDto;
use App\Domain\User\Store\SaveUserInterface;
use App\Store\Connection\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Logging\Exception;
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
        $this->insertUserToDataBase($dto);
        $this->saveFileAvatarToResource($dto);
        $this->entityManager->commit();
    }

    private function insertUserToDataBase(SaveUserDto $dto): void
    {
        $userEntity = Users::createFromSaveUserDto($dto);
        $this->entityManager->persist($userEntity);
        $this->entityManager->flush();
    }
    private function saveFileAvatarToResource(SaveUserDto $dto): void
    {
        $type = explode('/', $dto->mimeType)[1];
        $this->filesystem->copy($dto->tempUrlAvatar, "/app/public/images/{$dto->userDTO->id}.{$type}");
    }
}