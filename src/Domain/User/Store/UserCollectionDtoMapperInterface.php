<?php

namespace App\Domain\User\Store;

use App\Domain\User\Store\DTO\Collection\UserDtoCollection;

interface UserCollectionDtoMapperInterface
{
    public function mapFromArray(array $data): UserDtoCollection;
    public function mapToArray(UserDtoCollection $collectionDTO): array;
    public function mapToJson(UserDtoCollection $collectionDTO): string;
}