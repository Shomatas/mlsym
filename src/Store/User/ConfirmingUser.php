<?php

namespace App\Store\User;

use App\Domain\User\Store\ConfirmingUserInterface;
use App\Store\Connection\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;

class ConfirmingUser implements ConfirmingUserInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    )
    {
    }

    public function confirm(Uuid $id): void
    {
        $user = $this->entityManager->getRepository(Users::class)->find($id);
        $user->setIsConfirmed(true);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}