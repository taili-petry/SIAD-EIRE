<?php
require "conexao.php";

$car = $_GET['car'] ?? '';

// Converte o WKB para GeoJSON diretamente no MySQL
$sql = "
    SELECT ST_AsGeoJSON(coordenadas) AS geojson
    FROM poligonos
    WHERE car = '$car'
";

$res = $conn->query($sql);

$poligonos = [];

while ($row = $res->fetch_assoc()) {
    // Como o MySQL já retorna GeoJSON como string,
    // agora sim podemos transformar em array PHP:
    $poligonos[] = json_decode($row["geojson"], true);
}

echo json_encode($poligonos);
?>
