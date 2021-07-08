<?php

// Set the JSON header
header("Content-type: text/json");

include '../../../seguranca.php';
include '../model/Manutencao.class.php';

$data1 = filter_input(INPUT_GET, "data1");
$data2 = filter_input(INPUT_GET, "data2");
$periodo = filter_input(INPUT_GET, "p");
$tipo = filter_input(INPUT_GET, "tipo");

if ($tipo === 'evento') {
    try {
        $manutencao = new Manutencao();
        $manutencao->setDataEntrada($data1);
        $manutencao->setDataSaida($data2);
        $erro = "0";
    } catch (Exception $ex) {
        $erro = $ex->getMessage();
    }

    $conexao = new Conexao();

    $result = array();

    $query = "select count(*) as contagem from manutencao "
            . "inner join manutencaofollowup on (manutencaofollowup.id_manutencao=manutencao.id_manutencao) "
            . "inner join followup on (followup.id_followup=manutencaofollowup.id_followup) "
            . "where followup.id_evento = 5 and data_followup between ? and ?";
    $stmt = $conexao->prepare($query);
    $stmt->bindValue(1, $manutencao->getDataEntrada() . " 00:00:00", PDO::PARAM_STR);
    $stmt->bindValue(2, $manutencao->getDataSaida() . " 23:59:00", PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $total = array();
    $total = "(" . $data1 . " a " . $data2 . "): " . $row['contagem'];

    $query = "select to_char(data_followup::timestamp without time zone, 'dd/mm/YYYY'::text) AS data_formatada, data_followup, count(*) from manutencao "
            . "inner join manutencaofollowup on (manutencaofollowup.id_manutencao=manutencao.id_manutencao) "
            . "inner join followup on (followup.id_followup=manutencaofollowup.id_followup) "
            . "where followup.id_evento = 5 and data_followup between ? and ? "
            . "group by data_followup "
            . "order by data_followup asc";
    $stmt = $conexao->prepare($query);
    $stmt->bindValue(1, $manutencao->getDataEntrada() . " 00:00:00", PDO::PARAM_STR);
    $stmt->bindValue(2, $manutencao->getDataSaida() . " 23:59:00", PDO::PARAM_STR);
    $stmt->execute();


    $dias = array();
    $total_dia = array();

    while ($row = $stmt->fetch()) {
        array_push($dias, $row[0]);
        array_push($total_dia, (int) $row[2]);
    }

    $data_grafico = array('dias' => $dias, 'totaldia' => $total_dia, 'total' => $total, 'erro' => $erro);

    echo json_encode($data_grafico);
} else {


    if ($periodo === "u7") {
        $data1 = date('d/m/Y', strtotime('-1 week'));
        $data2 = date('d/m/Y');
    } else {
        
    }

    try {
        $manutencao = new Manutencao();
        $manutencao->setDataEntrada($data1);
        $manutencao->setDataSaida($data2);
        $erro = "0";
    } catch (Exception $ex) {
        $erro = $ex->getMessage();
    }

    $conexao = new Conexao();

    $query = "select "
            . "count(*) as contagem "
            . "from manutencao "
            . "where data_entrada between ? and ?";
    $stmt = $conexao->prepare($query);
    $stmt->bindValue(1, $manutencao->getDataEntrada(), PDO::PARAM_STR);
    $stmt->bindValue(2, $manutencao->getDataSaida(), PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $total = array();
    $total = "(" . $data1 . " a " . $data2 . "): " . $row['contagem'];

    $query = "select "
            . "to_char(data_entrada::timestamp without time zone, 'dd/mm/YYYY'::text) AS data_formatada,"
            . "data_entrada, "
            . "count(*) as contagem "
            . "from manutencao "
            . "where data_entrada between ? and ? "
            . "group by data_entrada "
            . "order by data_entrada asc";
    $stmt = $conexao->prepare($query);
    $stmt->bindValue(1, $manutencao->getDataEntrada(), PDO::PARAM_STR);
    $stmt->bindValue(2, $manutencao->getDataSaida(), PDO::PARAM_STR);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $dias = array();
    $items = array();

    foreach ($rows as $row) {
        $dias = array("dia" => $row['data_formatada'], "value" => (int) $row['contagem']);
        array_push($items, $dias);
    }

    $data_grafico = array('dias' => $items, 'total' => $total, 'erro' => $erro);

    echo json_encode($data_grafico);
}
