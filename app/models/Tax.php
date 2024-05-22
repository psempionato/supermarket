<?php

namespace app\models;

class Tax
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    
    public function getAll() 
    {
        return $this->db->query("SELECT t.*, pt.name AS product_type FROM taxes t INNER JOIN product_types pt ON t.product_type_id = pt.id;")->fetchAll();
    }

    public function create(int $productTypeId, float $taxPercentage)
    {
        $stmt = $this->db->prepare("INSERT INTO taxes (product_type_id, tax_percentage) VALUES (:productTypeId, :taxPercentage)");
        $parameters = [
            ':productTypeId' => $productTypeId,
            ':taxPercentage' => $taxPercentage
        ];
        return $this->db->execute($stmt, $parameters);
    }

    public function delete(int $taxId)
    {
        $stmt = $this->db->prepare("DELETE FROM taxes WHERE id = :id");
        $parameters = [':id' => $taxId];
        return $stmt->execute($parameters);
    }

    public function findByProducTypetId($productTypeId)
    {
        $stmt = $this->db->prepare("SELECT * FROM taxes WHERE product_type_id = :product_type_id");
        $stmt->execute([':product_type_id' => $productTypeId]);
        return $stmt->fetch();
    }
}