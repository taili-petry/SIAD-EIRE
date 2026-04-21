<?php
header("Content-Type: application/json; charset=UTF-8");
require_once "conexao.php";

if (!isset($_GET['car'])) {
    echo json_encode([
        "erro" => true,
        "mensagem" => "CAR não informado."
    ]);
    exit;
}

$car = $_GET['car'];

$sql = "
    SELECT 
        id_energia,
        car,
        ano,
        mes,
        consumo_kwh,
        custo_total,
        fonte,
        atividade
    FROM energia
    WHERE car = ?
    ORDER BY mes ASC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $car);
$stmt->execute();
$result = $stmt->get_result();

$registros = [];
while ($row = $result->fetch_assoc()) {
    $registros[] = $row;
}

echo json_encode([
    "erro" => false,
    "car" => $car,
    "registros" => $registros
]);

