<?php

namespace app\models;

use app\models\Database;

class Product
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        return $this->db->query("SELECT p.*, pt.name AS product_type FROM products p INNER JOIN product_types pt ON p.product_type_id = pt.id;")->fetchAll();
    }

    public function create(string $name, float $price, int $productTypeId)
    {
        $stmt = $this->db->prepare("INSERT INTO products (name, price, product_type_id) VALUES (:name, :price, :productTypeId)");
        $parameters = [
            ':name' => $name,
            ':price' => $price,
            ':productTypeId' => $productTypeId
        ];
        return $this->db->execute($stmt, $parameters);
    }

    public function delete(int $productId)
    {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = :id");
        $parameters = [':id' => $productId];
        return $stmt->execute($parameters);
    }

    public function getProductByName($name)
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE name ILIKE :name");
        $stmt->execute([':name' => '%' . $name . '%']);
        return $stmt->fetch();
    }
}