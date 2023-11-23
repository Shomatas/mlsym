<?php

namespace App\Store\Connection;

class Db
{
    private const DSN = "pgsql:host=172.24.32.1;port=5432;dbname=lsym;";
    private const DB_USER = "postgres";
    private const DB_PASSWORD = "1234";
    public const DB_TABLE_USER_NAME = "users";
    private static self|null $instance = null;
    private \PDO $pdo;
    private function __construct()
    {

    }

    public static function getInstance(): self
    {
        if (is_null(self::$instance))
        {
            self::$instance = new self;
            self::$instance->pdo = new \PDO(self::DSN, self::DB_USER, self::DB_PASSWORD);
        }
        return self::$instance;
    }

    public function request(string $query, array $data, bool $isSelectAll = false): array
    {
        $statement = self::$instance->pdo->prepare($query);
        $statement->execute($data);
        if ($isSelectAll) {
            return $statement->fetchAll(\PDO::FETCH_NAMED);
        }
        return $statement->fetch(\PDO::FETCH_NAMED);
    }

    public function getLastInsertId(): int
    {
        return self::$instance->pdo->lastInsertId();
    }

}