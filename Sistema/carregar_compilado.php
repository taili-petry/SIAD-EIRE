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

$sql = " SELECT 
        dc.id_compilado,
        dc.car,
        dc.ano,
        dc.area_total_ha,
        dc.area_irrigada_total_m2,
        dc.volume_agua_total_m3,
        dc.energia_consumida_kwh,
        dc.produtividade_total_kg,
        p.nome_propriedade
    FROM dados_compilados dc
    LEFT JOIN propriedades p ON p.car = dc.car
    WHERE dc.car = ?
    LIMIT 1
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $car);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["erro" => true, "mensagem" => "Nenhum dado encontrado."]);
    exit;
}

$dados = $result->fetch_assoc();

echo json_encode([
    "erro" => false,
    "compilado" => $dados
]);
