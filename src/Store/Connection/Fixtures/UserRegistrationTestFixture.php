<?php

namespace App\Store\Connection\Fixtures;

use App\Store\Connection\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;

class UserRegistrationTestFixture extends Fixture
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; ++$i) {
            $user = new Users(
                Uuid::v1(),
                "qpie_{$i}",
                "1233214",
                "Ilya_{$i}",
                "Pomazenkov_{$i}",
                $i * 10,
                "qpie@gmail.ru",
                "+7(937)126-08-22",
                "Russia_{$i}",
                "Zhizdra_{$i}",
                "Polynaya_{$i}",
                "{$i}b",
                "gif",
            );

            $manager->persist($user);
        }

        $manager->flush();
    }
}