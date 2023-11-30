<?php

namespace App\Domain\User\Store\DTO;

readonly class FileSaveDto
{
    public function __construct(
        public string $tempPath = "",
        public string $mimeType = "",
    )
    {

    }
}