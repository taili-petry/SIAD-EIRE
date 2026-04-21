<?php
header("Content-Type: application/json");
$pdo = new PDO("mysql:host=localhost;dbname=siad_eire","root","");

$query = $pdo->query("SELECT id, nome, car FROM propriedades");
echo json_encode($query->fetchAll(PDO::FETCH_ASSOC));
