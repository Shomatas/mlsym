<?php

namespace App\Store\User;

use App\Store\Connection\Db;
use App\Domain\User\Store\DTO\UserRegisterDTO;
use App\Domain\User\Store\SaveUserInterface;

class SaveUser implements SaveUserInterface
{

    public function save(UserRegisterDTO $dto): int
    {
        $db = Db::getInstance();
        $tableName = Db::DB_TABLE_USER_NAME;
        $query = "INSERT INTO {$tableName} (login, password) VALUES (:login, :password)";
        $data = [
            "login" => $dto->userDTO->login,
            "password" => $dto->userDTO->password,
        ];
        $db->request($query, $data);
        return $db->getLastInsertId();
    }
}