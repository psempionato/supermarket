<?php

namespace app\controllers;

use app\models\Database;
use app\models\Sale;
use app\models\SaleItem;

class SaleController
{

    private $sale;
    private $saleItem;

    public function __construct()
    {
        $database = new Database();
        $this->sale = new Sale($database);
        $this->saleItem = new SaleItem($database);
    }
    
    public function index()
    {
        include __DIR__ . '../../views/sales/index.php';
    }

    public function store()
    {
        $postData = file_get_contents('php://input');

        $saleData = json_decode($postData, true);

        if ($saleData === null) {
            http_response_code(400);
            echo json_encode(array('message' => 'Erro ao decodificar JSON.'));
            exit;
        }

        try {
            $this->sale->create();
            $saleId = $this->sale->lastInsertdId();
            
            foreach ($saleData as $item) {
                $this->saleItem->create($saleId['id'], $item['id'], $item['quantity'], $item['unitPrice']);
            }
            echo "Venda salvo com sucesso";
        } catch (\Throwable $th) {
            echo "Erro ao salvar a venda: " . $th->getMessage();
        }
    }
}