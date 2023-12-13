<?php

namespace App\Store\Connection\Fixtures;

use App\Store\Connection\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;

class UsersControllerGetAllUsersFixture extends Fixture
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; ++$i) {
            $user = new Users(
                Uuid::v1(),
                "paff_{$i}",
                "3214",
                "Ivan_{$i}",
                "Komarov_{$i}",
                $i,
                "vano{$i}komarov@mail.ru",
                "8937126082{$i}",
                "Russia_{$i}",
                "Kaluga_{$i}",
                "Suvorova_{$i}",
                "{$i}a",
                "png",
            );

            $manager->persist($user);
        }

        $manager->flush();
    }
}