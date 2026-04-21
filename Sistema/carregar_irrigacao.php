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
        id_irrigacao,
        car,
        data_registro,
        DATE_FORMAT(data_registro, '%b') AS mes_abrev,
        UPPER(DATE_FORMAT(data_registro, '%b')) AS mes,
        vazao_m3_h,
        area_irrigada_m2,
        volume_total_m3,
        metodo,
        observacoes
    FROM irrigacao
    WHERE car = ?
    ORDER BY data_registro
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
