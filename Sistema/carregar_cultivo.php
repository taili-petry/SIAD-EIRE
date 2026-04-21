<?php
header("Content-Type: application/json; charset=UTF-8");
require "conexao.php";

if (!isset($_GET['car'])) {
    echo json_encode(["erro" => "CAR não enviado."]);
    exit;
}

$car = $_GET['car'];

$sql = $conn->prepare("
        SELECT 
        id_cultivo,
        car,
        tipo_cultura,
        data_inicio,
        DATE_FORMAT(data_inicio, '%b') AS mes_abrev_ini,
        UPPER(DATE_FORMAT(data_inicio, '%b')) AS mes_ini,
        data_fim,
        DATE_FORMAT(data_fim, '%b') AS mes_abrev_fim,
        UPPER(DATE_FORMAT(data_fim, '%b')) AS mes_fim,
        area_cultivada_m2,
        produtividade_kg,
        previsao_colheita,
        DATE_FORMAT(previsao_colheita, '%b') AS mes_abrev_prev,
        UPPER(DATE_FORMAT(previsao_colheita, '%b')) AS mes_prev,
        observacoes
    FROM cultivo
    WHERE car = ?
");
$sql->bind_param("s", $car);
$sql->execute();
$result = $sql->get_result();

$dados = [];

while ($row = $result->fetch_assoc()) {
    $dados[] = $row;
}

echo json_encode([
    "status" => "ok",
    "car" => $car,
    "registros" => $dados
]);
