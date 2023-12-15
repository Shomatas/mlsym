<?php

namespace App\Domain\User\Store;

use App\Domain\User\Store\DTO\SaveUserDto;

interface SaveUserDtoDataMapperInterface
{
    public function mapToArray(SaveUserDto $saveUserDto): array;
    public function mapToJson(SaveUserDto $saveUserDto): string;
    public function mapFromArray(array $data): SaveUserDto;
    public function mapFromJson(string $data): SaveUserDto;
}