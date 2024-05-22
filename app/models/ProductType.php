<?php

namespace app\models;

class ProductType {

    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    
    public function getAll() 
    {
        $stmt = $this->db->query("SELECT * FROM product_types");
        return $this->db->fetchAll($stmt);
    }

    public function create(string $name) 
    {
        $stmt = $this->db->prepare("INSERT INTO product_types (name) VALUES (:name)");
        $parameters = [
            ':name' => $name
        ];
        return $this->db->execute($stmt, $parameters);
    }
}