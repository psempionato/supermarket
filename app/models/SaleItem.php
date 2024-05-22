<?php

namespace app\models;

class SaleItem
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function create(int $sale_id, int $product_id, int $quantity, float $price)
    {
        $stmt = $this->db->prepare("INSERT INTO sale_items (sale_id, product_id, quantity, price) VALUES (:sale_id, :product_id, :quantity, :price)");
        $parameters = [
            ':sale_id' => $sale_id,
            ':product_id' => $product_id,
            ':quantity' => $quantity,
            ':price' => $price
        ];
        return $this->db->execute($stmt, $parameters);
    }
}