<?php

declare(strict_types=1);

namespace App\Product;

use App\Database\Database;

class Product
{
    public function __construct(
        private readonly Database $db
    ) {
    }
    public function addProduct(string $title, string $description, float $price): void
    {
        if (!$this->tableExists('products')) {
            $this->addTable();
        }
        $sql = "INSERT INTO products (title, description, price) VALUES (:title, :description, :price)";
        $stmt = $this->db->conn()->prepare($sql);
        $stmt->execute([
            ':title' => $title,
            ':description' => $description,
            ':price' => $price
        ]);
    }
    private function tableExists(string $tableName): bool
    {
        $sql = 'SHOW TABLES LIKE :table';
        $stmt = $this->db->conn()->prepare($sql);
        $stmt->execute([':table' => $tableName]);
        return $stmt->rowCount() > 0;
    }
    private function addTable(): void
    {
        $sql = 'CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(100) UNIQUE,
        description TEXT,
        price DECIMAL(10,2),
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )';
        $this->db->conn()->exec($sql);
    }
}
