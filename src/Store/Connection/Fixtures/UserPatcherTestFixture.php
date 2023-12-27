<?php

namespace App\Store\Connection\Fixtures;

use App\Domain\User\UserPatcher;
use App\Store\Connection\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;

class UserPatcherTestFixture extends Fixture
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $idData = json_decode(file_get_contents(__DIR__ . '/resource/idData.json'), true)["data"];
        foreach ($idData as $id) {
            $user = new Users(
                Uuid::fromString($id),
                "prysson_{$id}",
                "1234{$id}",
                "Kiril",
                "Petruhno",
                27,
                "prysson{$id}@mail.ru",
                null,
                "Russia",
                "Kaluga",
                "North",
                "22",
                "jpeg",
            );
            $manager->persist($user);
        }
        $manager->flush();
    }
}