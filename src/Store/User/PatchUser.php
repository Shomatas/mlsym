<?php

namespace App\Store\User;

use App\Domain\Address\Store\DTO\PatchAddressDto;
use App\Domain\User\Store\DTO\PatchProfileDto;
use App\Domain\User\Store\DTO\PatchUserDto;
use App\Domain\User\Store\PatchUserInterface;
use App\Store\Connection\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;

class PatchUser implements PatchUserInterface
{
    public function __construct(
        public EntityManagerInterface $entityManager,
    )
    {
    }

    public function patch(PatchUserDto $patchUserDto): void
    {
        $user = $this->entityManager->getRepository(Users::class)->find($patchUserDto->id);
        $this->patchLogin($user, $patchUserDto->login);
        $this->patchPassword($user, $patchUserDto->password);
        $this->patchProfile($user, $patchUserDto->profileDto);
        $this->patchAddress($user, $patchUserDto->addressDto);
        $this->patchEmail($user, $patchUserDto->email);
        $this->patchPhone($user, $patchUserDto->phone);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    private function patchLogin(Users $user, ?string $login): void
    {
        if (!is_null($login)) {
            $user->setLogin($login);
        }
    }

    private function patchPassword(Users $user, ?string $password): void
    {
        if (!is_null($password)) {
            $user->setPassword($password);
        }
    }

    private function patchProfile(Users $user, ?PatchProfileDto $profile): void
    {
        if (!is_null($profile?->firstname)) {
            $user->setFirstname($profile->firstname);
        }
        if (!is_null($profile?->lastname)) {
            $user->setLastname($profile->lastname);
        }
        if (!is_null($profile?->age)) {
            $user->setAge($profile->age);
        }
    }

    private function patchAddress(Users $user, ?PatchAddressDto $address): void
    {
        if (!is_null($address?->country)) {
            $user->setLogin($address->country);
        }
        if (!is_null($address?->city)) {
            $user->setLogin($address->city);
        }
        if (!is_null($address?->street)) {
            $user->setLogin($address->street);
        }
        if (!is_null($address?->houseNumber)) {
            $user->setLogin($address->houseNumber);
        }
    }

    private function patchEmail(Users $user, ?string $email): void
    {
        if (!is_null($email)) {
            $user->setEmail($email);
        }
    }

    private function patchPhone(Users $user, ?string $phone): void
    {
        if (!is_null($phone)) {
            $user->setPhone($phone);
        }
    }
}