<?php

require_once '../models/Database.php';

try {
    $db = new Database();

    $sql = "SELECT 1";
    $result = $db->query($sql);

    if ($result) {
        echo "Conexão com o banco estabelecida com sucesso";
    } else {
        echo "Falha na conexão AHHHH";
    }
} catch (\Throwable $th) {
    echo "falha no banco " . $e->getMessage();
}