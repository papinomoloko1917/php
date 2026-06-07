<?php

declare(strict_types=1);

namespace App\Database;

use PDO;

class Database
{
    public function __construct(
        private readonly string $servername,
        private readonly string $username,
        private readonly string $password,
        private readonly string $dbname,
    ) {
    }
    public static function fromEnv(): self
    {
        return new self(
            getenv('MYSQL_CONTAINER_NAME'),
            getenv('MYSQL_USER'),
            getenv('MYSQL_PASSWORD'),
            getenv('MYSQL_DATABASE'),
        );
    }
    public function conn(): PDO
    {
        $dsn = "mysql:host={$this->servername};dbname={$this->dbname};charset=utf8mb4";
        return new PDO(
            $dsn,
            $this->username,
            $this->password
        );
    }
}
