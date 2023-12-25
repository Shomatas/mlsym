<?php

namespace App\Domain\User\Store;

use Symfony\Component\Uid\Uuid;

interface DeletingUserInterface
{
    public function delete(Uuid $id): void;
}