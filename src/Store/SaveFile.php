<?php

namespace App\Store;

use App\Domain\User\Store\DTO\FileSaveDto;
use App\Domain\User\Store\DTO\SavedFileDto;
use App\Domain\User\Store\SaveFileInterface;
use Symfony\Component\Uid\Uuid;

class SaveFile implements SaveFileInterface
{

    public function save(FileSaveDto $fileSaveDto): SavedFileDto
    {
        $newFilename = Uuid::v1();
        $type = explode('/', $fileSaveDto->mimeType)[1];
        $newPath = "images/{$newFilename}.{$type}";

        move_uploaded_file($fileSaveDto->tempPath, $newPath);

        return new SavedFileDto($newPath);
    }
}