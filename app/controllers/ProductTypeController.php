<?php

namespace app\controllers;

use app\models\Database;
use app\models\ProductType;

class ProductTypeController
{
    private $productType;

    public function __construct()
    {
        $database = new Database();
        $this->productType = new ProductType($database);
    }

    public function index()
    {
        $productTypes = $this->productType->getAll();
        include __DIR__ . '../../views/product_types/index.php';
    }

    public function create()
    {
        include __DIR__ . '../../views/product_types/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
            
            if ($name !== false) {
                try {
                    $this->productType->create($name);
                    header("Location: /product_types");
                    exit;
                } catch (\Throwable $th) {
                    error_log("Erro ao criar o produto: " . $th->getMessage());
                    header("Location: /index.php");
                    exit;
                }
            } else {
                header("Location: /index.php");
                exit;
            }
        } else {
            header("Location: /index.php");
            exit;
        }
    }
}