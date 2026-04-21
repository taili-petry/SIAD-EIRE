<?php
require "conexao.php";

$area = $_GET['area'] ?? '';
$car  = $_GET['car'] ?? '';

$response = [];

if ($area === "propriedades") {

    $sql = "
        SELECT 
            nome_propriedade, 
            car, 
            nome_produtor,
            municipio,
            latitude, 
            longitude, 
            area_total_m2, 
            area_total_ha 
        FROM propriedades
    ";
    
    $res = $conn->query($sql);

    $propriedades = [];
    $total_area_m2 = 0;
    $total_ha = 0;

    while ($row = $res->fetch_assoc()) {

        // Converte coordenadas p/ número
        $row['latitude'] = floatval($row['latitude']);
        $row['longitude'] = floatval($row['longitude']);

        $propriedades[] = $row;

        $total_area_m2 += $row['area_total_m2'];
        $total_ha += $row['area_total_ha'];
    }

    $response = [
        "propriedades"        => $propriedades,
        "total_propriedades"  => count($propriedades),
        "total_area_m2"       => $total_area_m2,
        "total_area_ha"       => $total_ha
    ];
}

if ($area === "dashboard") {

    $sql = "
        SELECT 
            e.ano,
            e.mes,
            e.consumo_kwh,
            e.custo_total,
            e.fonte,
            COALESCE(i.volume_total_m3, 0) AS volume_total_m3,
            COALESCE(i.area_irrigada_m2, 0) AS area_irrigada_m2,
            i.metodo
        FROM energia e
        LEFT JOIN (
            SELECT 
                car,
                YEAR(data_registro) AS ano,
                MONTH(data_registro) AS mes,
                SUM(volume_total_m3) AS volume_total_m3,
                SUM(area_irrigada_m2) AS area_irrigada_m2,
                MAX(metodo) AS metodo
            FROM irrigacao
            WHERE car = ?
            GROUP BY car, YEAR(data_registro), MONTH(data_registro)
        ) i
            ON i.car = e.car
        AND i.ano = e.ano
        AND i.mes = e.mes
        WHERE e.car = ?
        ORDER BY e.ano, e.mes;

    ";

    $sqlCultivo = "
        SELECT 
            tipo_cultura,
            produtividade_kg,
            area_cultivada_m2
        FROM cultivo
        WHERE car = ?
    ";



    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $car, $car);
    $stmt->execute();
    $res = $stmt->get_result();

    $registros = [];
    while ($row = $res->fetch_assoc()) {
        $registros[] = $row;
    }

    $stmt2 = $conn->prepare($sqlCultivo);
    $stmt2->bind_param("s", $car);
    $stmt2->execute();
    $res2 = $stmt2->get_result();

    $cultivos = [];
    while ($row = $res2->fetch_assoc()) {
        $cultivos[] = $row;
    }

    $response = [
        "registros" => $registros,
        "cultivos" => $cultivos
    ];
}




echo json_encode($response);
