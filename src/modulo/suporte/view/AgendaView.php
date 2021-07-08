<?php

include '../../../seguranca.php';

$conexao = new Conexao();
$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$start = filter_input(INPUT_GET, "start");
$end = filter_input(INPUT_GET, "end");
$usuario = filter_input(INPUT_GET, "usuario");

if(!empty($usuario)) {
    $addQuery = "AND sptarefa_u_atribuido = " . $usuario;
} else {
    $addQuery = "";
}

$query = "SELECT * "
        . "FROM vw_tarefa "
        . "WHERE sptarefa_dt_tarefa "
        . "BETWEEN (:start::timestamp) AND (:end::timestamp) " . $addQuery . " "
        . "ORDER BY sptarefa_id DESC";
$stmt = $conexao->prepare($query);
$stmt->bindParam(':start', $start, PDO::PARAM_STR);
$stmt->bindParam(':end', $end, PDO::PARAM_STR);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$linha = array();
$items = array();

foreach ($rows as $row) {
    if ($row['sptarefa_status'] === true) {
        $cor = '#000000';
        $texto = '#727272';
    } else {
        $cor = '#2196F3';
        $texto = '#ffffff';
    }

    $cliente = $row['crcliente_fantasia'];
    $titulo = "Por: " . $row['sptarefa_u_atribuido_nome'];
    $titulo_corpo = $row['sptarefa_titulo'] . "\nPor: " . $row['sptarefa_u_atribuido_nome'];
    $chamado_titulo = $row['spchamado_titulo'];
    $linha = array("id" => $row['sptarefa_id'], "title" => $titulo_corpo, "start" => $row['sptarefa_dt_tarefa'], "end" => $row['sptarefa_dt_vto'], "color" => $cor, "textColor" => $texto, "descricao" => $row['sptarefa_desc'], "titulo" => $titulo, "chamado" => $chamado_titulo, "chamado_id" => $row['spchamado_id'], "cliente" => $cliente);
    array_push($items, $linha);
}

echo json_encode($items);
