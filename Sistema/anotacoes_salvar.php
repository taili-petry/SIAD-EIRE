<?php
header("Content-Type: application/json; charset=UTF-8");
require_once "conexao.php";

$data = json_decode(file_get_contents("php://input"), true);

$anotacao = trim($data["anotacao"] ?? "");
$car = $data["car"] ?? null;

// Se vier string vazia "", transforma em NULL
if ($car === "") {
    $car = null;
}

if ($anotacao === "") {
    echo json_encode(["erro" => true, "mensagem" => "Anotação vazia."]);
    exit;
}

$sql = "INSERT INTO anotacoes (anotacao, car) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $anotacao, $car);

if ($stmt->execute()) {
    echo json_encode(["erro" => false]);
} else {
    echo json_encode(["erro" => true, "mensagem" => "Erro ao salvar."]);
}
