<?php

namespace app\controllers;

use app\models\Database;
use app\models\Product;
use app\models\ProductType;
use app\models\Tax;

class ProductController
{
    private $product;
    private $productType;
    private $tax;

    public function __construct()
    {
        $database = new Database();
        $this->product = new Product($database);
        $this->productType = new ProductType($database);
        $this->tax = new Tax($database);
    }

    public function index()
    {
        $products = $this->product->getAll();
        include __DIR__ . '../../views/products/index.php';
    }

    public function create()
    {
        $productTypes = $this->productType->getAll();
        include __DIR__ . '../../views/products/create.php';
    }

    public function store($params)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
            $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
            $productTypeId = filter_input(INPUT_POST, 'product_type_id', FILTER_VALIDATE_INT);

            if ($name && $price !== false && $productTypeId !== false) {
                try {
                    $this->product->create($name, $price, $productTypeId);
                    header("Location: /products");
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
                $this->product->delete((int)$params->product_id);
                header("Location: /products");
                exit;
            } catch (\Throwable $th) {
                error_log("Erro ao deletar o produto: " . $th->getMessage());
                header("Location: /index.php");
                exit;
            }
        }
    }

    public function getProductByName($params)
    {
        $product = $this->product->getProductByName($params->name);
        
        if ($product) {
            $tax_percentage = $this->getTaxPercentage($product['product_type_id']);
            $product['tax_percentage'] = $tax_percentage;
    
            header('Content-Type: application/json');
            echo json_encode($product);
        } else {
            header('Content-Type: application/json', true, 404);
            echo json_encode(['error' => 'Produto não encontrado']);
        }
    }

    public function getTaxPercentage($productTypeId)
    {
        $tax = $this->tax->findByProducTypetId($productTypeId);
        return $tax['tax_percentage'];
    }
}