<?php

namespace App\Domain\User\Store\DTO;

class SavedFileDto
{
    public function __construct(
        public string $pathToAvatar = "",
    )
    {

    }
}