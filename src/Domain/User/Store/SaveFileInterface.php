<?php

namespace App\Domain\User\Store;

use App\Domain\User\Store\DTO\FileSaveDto;
use App\Domain\User\Store\DTO\SavedFileDto;

interface SaveFileInterface
{
    public function save(FileSaveDto $fileSaveDto): SavedFileDto;
}