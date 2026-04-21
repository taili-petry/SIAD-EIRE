<?php
header("Content-Type: application/json");
$pdo = new PDO("mysql:host=localhost;dbname=siad_eire","root","");

$input = json_decode(file_get_contents("php://input"), true);

$stmt = $pdo->prepare("
    INSERT INTO geometrias_propriedade (propriedade_id, geojson)
    VALUES (?, ?)
");

$geojson = json_encode([
    "type" => "Polygon",
    "coordinates" => [ array_map(fn($c)=>[$c['lng'],$c['lat']], $input['coordenadas']) ]
]);

$stmt->execute([1, $geojson]); // EXEMPLO, depois você adapta

echo json_encode(["status"=>"ok"]);
