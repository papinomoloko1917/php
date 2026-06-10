<?php

declare(strict_types=1);

namespace App\Database;

final class Connect
{
    private readonly string $dsn;
    public function __construct(
        private readonly string $host_name,
        private readonly string $db_name,
        private readonly string $user_name,
        private readonly string $password,
    ) {
    }
}
