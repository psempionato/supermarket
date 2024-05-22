<?php

namespace app\controllers;

use app\models\Database;
use app\models\ProductType;
use app\models\Tax;

class TaxController
{
    private $tax;
    private $productType;

    public function __construct()
    {
        $database = new Database();
        $this->tax = new Tax($database);
        $this->productType = new ProductType($database);
    }

    public function index()
    {
        $taxes = $this->tax->getAll();
        include __DIR__ . '../../views/taxes/index.php';
    }

    public function create()
    {
        $productTypes = $this->productType->getAll();
        include __DIR__ . '../../views/taxes/create.php';
    }

    public function store($params)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $productTypeId = filter_input(INPUT_POST, 'product_type_id', FILTER_VALIDATE_INT);
            $tax_percentage = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);

            if ($productTypeId !== false && $tax_percentage !== false) {
                try {
                    $this->tax->create($productTypeId, $tax_percentage);
                    header("Location: /taxes");
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

    public function delete($params)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $this->tax->delete((int)$params->tax_id);
                header("Location: /taxes");
                exit;
            } catch (\Throwable $th) {
                error_log("Erro ao deletar o produto: " . $th->getMessage());
                header("Location: /index.php");
                exit;
            }
        }
    }


}