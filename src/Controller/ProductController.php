<?php

declare(strict_types=1);

namespace App\Controller;

use App\Database\Database;
use App\Request\Request;
use App\View\View;

class ProductController extends Controller
{
    public function __construct(
        protected readonly View $view,
        private readonly Request $request,
        private readonly Database $database,
    ) {
    }
    public function addProduct()
    {
        return $this->view('product/add_product');
    }
    public function storeProduct(): void
    {
        $title = $this->request->input('title');
        $description = $this->request->input('description');
        $price = $this->request->input('price');

        if (!$this->tableExists('products')) {
            $this->addTable();
        }
        $sql = "INSERT INTO products (title, description, price) VALUES (:title, :description, :price)";
        $stmt = $this->database->conn()->prepare($sql);
        $stmt->execute([
            ':title' => $title,
            ':description' => $description,
            ':price' => $price
        ]);

        header('Location: /');
        exit;
    }
    private function tableExists(string $tableName): bool
    {
        $sql = 'SHOW TABLES LIKE :table';
        $stmt = $this->database->conn()->prepare($sql);
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
        $this->database->conn()->exec($sql);
    }
}
