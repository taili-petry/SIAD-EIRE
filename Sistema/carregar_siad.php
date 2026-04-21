<?php
header('Content-Type: application/json');
$car = $_GET['car'] ?? '';

if (!$car) {
    echo json_encode(['erro'=>true, 'mensagem'=>'CAR não informado']);
    exit;
}

include 'conexao.php';

// --- IRRIGAÇÃO ---
$sqlIrrig = "SELECT area_irrigada_m2, volume_total_m3, metodo FROM irrigacao WHERE car=? ORDER BY data_registro";
$stmt = $conn->prepare($sqlIrrig);
$stmt->bind_param("s",$car);
$stmt->execute();
$res = $stmt->get_result();
$irrigacao = $res->fetch_all(MYSQLI_ASSOC);

// --- CULTIVO ---
$sqlCultivo = "SELECT tipo_cultura, produtividade_kg FROM cultivo WHERE car=?";
$stmt = $conn->prepare($sqlCultivo);
$stmt->bind_param("s",$car);
$stmt->execute();
$res = $stmt->get_result();
$cultivo = $res->fetch_all(MYSQLI_ASSOC);

// --- ENERGIA ---
$sqlEnergia = "SELECT consumo_kwh, custo_total, fonte FROM energia WHERE car=?";
$stmt = $conn->prepare($sqlEnergia);
$stmt->bind_param("s",$car);
$stmt->execute();
$res = $stmt->get_result();
$energia = $res->fetch_all(MYSQLI_ASSOC);

echo json_encode([
    'erro'=>false,
    'registros_siad'=>[
        'irrigacao'=>$irrigacao,
        'cultivo'=>$cultivo,
        'energia'=>$energia
    ]
]);
