<?php

namespace app\models;

class Sale
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function create()
    {
        $stmt = $this->db->prepare("INSERT INTO sales (sale_date) VALUES (:sale_date)");
        $parameters = [
            ':sale_date' => date('Y-m-d H:i:s'),
        ];
        return $this->db->execute($stmt, $parameters);
    }

    public function lastInsertdId()
    {
        return $this->db->query("SELECT id FROM sales s ORDER BY id DESC LIMIT 1")->fetch();
    }
}