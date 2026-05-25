<?php

declare(strict_types=1);

namespace App\Support;

final class Env
{
    public function __construct()
    {
    }
    public static function write(string $filePath)
    {
        if (file_exists($filePath)) {
            $file = file($filePath, FILE_IGNORE_NEW_LINES);
        }
        dump($file);
    }
}
