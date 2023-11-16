<?php

namespace App\Store\User;

use App\Domain\User\Store\DTO\UserDTO;
use App\Store\Connection\Db;
use App\Tests\Domain\User\GetUserInterface;

class GetUser implements GetUserInterface
{

    public function get(int $id): UserDTO
    {
        $db = Db::getInstance();
        $tableName = \App\Store\Connection\Db::DB_TABLE_USER_NAME;

        $query = "SELECT * FROM {$tableName} WHERE id=:id";
        $data = [
            "id" => $id,
        ];


        $data = $db->request($query, $data);
        return new UserDTO($data["id"], $data["login"], $data["password"]);
    }
}