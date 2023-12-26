<?php

namespace App\Domain\User\Store;

use Symfony\Component\Uid\Uuid;

interface ConfirmingUserInterface
{
    public function confirm(Uuid $id): void;
}