<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "siad";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

mysqli_set_charset($conn, "utf8");
?>
