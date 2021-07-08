<?php

include '../../../seguranca.php';

$ano = filter_input(INPUT_POST, "spchamado_dt_ano");
if (empty($ano)) {
    $ano = date('Y');
}

$conexao = new Conexao();
$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$query = "SELECT "
        . "extract(month FROM spchamado_dt_abertura) AS spchamado_mes_nr, "
        . "mesporescrito(extract(month FROM spchamado_dt_abertura)::integer) AS spchamado_mes, "
        . "count(*) AS qtd "
        . "FROM spchamado "
        . "WHERE extract(year FROM spchamado_dt_abertura) = ? "
        . "GROUP BY spchamado_mes_nr, spchamado_mes "
        . "ORDER BY spchamado_mes_nr ASC";
$stmt = $conexao->prepare($query);
$stmt->bindValue(1, $ano, PDO::PARAM_INT);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$meses = array();
$items = array();

foreach ($rows as $row) {
    $meses = array("label" => $row['spchamado_mes'], "value" => (int) $row['qtd']);
    array_push($items, $meses);
}

$data_grafico = array('meses' => $items);

echo json_encode($data_grafico);
