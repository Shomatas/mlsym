<?php

namespace App\Store\User;

use App\Domain\User\Store\DTO\SaveUserDto;
use App\Domain\User\Store\TemporarySaveUserDtoInterface;
use Symfony\Component\Filesystem\Filesystem;

class TemporarySaveUserDto implements TemporarySaveUserDtoInterface
{

    public function __construct(
        private Filesystem $filesystem,
        private SaveUserDtoDataMapper $saveUserDtoDataMapper,
    )
    {
    }

    public function save(SaveUserDto $saveUserDto): void
    {
        $tempFilePath = $this->getTempFilePath($saveUserDto->userDTO->id);
        $tempImagePath = $this->getTempImagePath($saveUserDto->userDTO->id);
        $this->filesystem->touch($tempFilePath);
        $userDtoJson = $this->saveUserDtoDataMapper->mapToJson($saveUserDto);
        $this->filesystem->appendToFile($tempFilePath, $userDtoJson);
        $this->filesystem->copy($saveUserDto->tempUrlAvatar, $tempImagePath);
    }

    public function pop(string $id): SaveUserDto
    {
        $tempFilePath = $this->getTempFilePath($id);
        if (!$this->filesystem->exists($tempFilePath)) {
            throw new \RuntimeException("Stub exception");
        }
        $saveUserDto = $this->saveUserDtoDataMapper
            ->mapFromJson(file_get_contents($tempFilePath));
        $this->filesystem->remove($tempFilePath);
        return $saveUserDto;
    }

    private function getTempFilePath(string $id): string
    {
        return dirname(__DIR__) . "/../../public/temp/{$id}";
    }

    private function getTempImagePath(string $id): string
    {
        return  dirname(__DIR__) . "/../../public/temp/images/{$id}";
    }

}