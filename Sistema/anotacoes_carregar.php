<?php
header("Content-Type: application/json; charset=UTF-8");
require_once "conexao.php";

$sql = "SELECT id_anotacao, anotacao, car, 
        DATE_FORMAT(data_criacao,'%d/%m/%Y %H:%i') AS data_criacao
        FROM anotacoes
        ORDER BY data_criacao DESC";

$result = $conn->query($sql);

$lista = [];
while ($row = $result->fetch_assoc()) {
    $lista[] = $row;
}

echo json_encode($lista);
