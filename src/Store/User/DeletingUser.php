<?php

namespace App\Store\User;

use App\Domain\User\Store\DeletingUserInterface;
use App\Domain\User\Store\GetUserInterface;
use App\Store\Connection\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;

class DeletingUser implements DeletingUserInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {}

    public function delete(Uuid $id): void
    {
        $user = $this->entityManager->getRepository(Users::class)->find($id);
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }
}