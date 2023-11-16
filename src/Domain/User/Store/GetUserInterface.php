<?php

namespace App\Domain\User\Store;

interface GetUserInterface
{
    public function getAll(): array;
}