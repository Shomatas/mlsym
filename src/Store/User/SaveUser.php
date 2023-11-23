<?php

namespace App\Store\User;

use App\Entity\Users;
use App\Domain\User\Store\DTO\UserRegisterDTO;
use App\Domain\User\Store\SaveUserInterface;
use Doctrine\ORM\EntityManagerInterface;

class SaveUser implements SaveUserInterface
{

    public function __construct(
        private EntityManagerInterface $entityManager,
    )
    {
    }

    public function save(UserRegisterDTO $dto): void
    {
        $productEntity = Users::createFromUserDTO($dto->userDTO);
        $this->entityManager->persist($productEntity);
        $this->entityManager->flush();
    }
}