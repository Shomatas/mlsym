<?php

namespace App\Domain\User\Store;

use App\Domain\User\Store\DTO\UserCollectionDTO;

interface UserCollectionDtoMapperInterface
{
    public function mapFromArray(array $data): UserCollectionDTO;
    public function mapToArray(UserCollectionDTO $collectionDTO): array;
    public function mapToJson(UserCollectionDTO $collectionDTO): string;
}