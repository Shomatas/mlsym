<?php

namespace App\Store\Connection\Fixtures;

use App\Store\Connection\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;

class UsersControllerRegisterFixture extends Fixture
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; ++$i) {
            $user = new Users(
                Uuid::v1(),
                "n3dsky_{$i}",
                "3214123a",
                "Denis_{$i}",
                "Kosmynin_{$i}",
                $i,
                "n3dsky@yandex.ru",
                "8937126081{$i}",
                "Russia_{$i}",
                "Kaluga_{$i}",
                "Kirova_{$i}",
                "{$i}a",
                "jpeg",
            );

            $manager->persist($user);
        }

        $manager->flush();
    }
}