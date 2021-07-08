<?php

include '../../../seguranca.php';

$conexao = new Conexao();
$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$f1 = filter_input(INPUT_POST, "f1");
$dt1 = filter_input(INPUT_POST, "dt1");
$dt2 = filter_input(INPUT_POST, "dt2");

if (!empty($dt1) && !empty($dt2)) {
    $filtroI = formataData($dt1);
    $filtroF = date('Y-m-d', strtotime(formataData($dt2) . ' +1 day'));
} elseif ($f1 === 'u7') {
    $filtroI = '-1 week';
    $filtroF = '+1 day';
} elseif ($f1 === 'u1') {
    $filtroI = '-1 day';
    $filtroF = '+1 day';
} else {
    $filtroI = '-1 month';
    $filtroF = '+1 day';
}

$data1 = date('Y-m-d', strtotime($filtroI));
$data2 = date('Y-m-d', strtotime($filtroF));

$query = "SELECT "
        . "to_char(spchamado_dt_abertura::date, 'dd/mm/YYYY'::text) AS spchamado_dt_abertura_fmt, "
        . "spchamado_dt_abertura::date, "
        . "count(*) AS qtd "
        . "FROM spchamado "
        . "WHERE spchamado_dt_abertura BETWEEN ? AND ? "
        . "GROUP BY spchamado_dt_abertura::date "
        . "ORDER BY spchamado_dt_abertura::date ASC";
$stmt = $conexao->prepare($query);
$stmt->bindValue(1, $data1, PDO::PARAM_STR);
$stmt->bindValue(2, $data2, PDO::PARAM_STR);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$dias = array();
$items = array();

foreach ($rows as $row) {
    $dias = array("dia" => $row['spchamado_dt_abertura_fmt'], "value" => (int) $row['qtd']);
    array_push($items, $dias);
}

$data_grafico = array('dias' => $items);

echo json_encode($data_grafico);

function formataData($data) {
    $data = trim($data);
    $data = str_replace("/", "-", $data);
    date_default_timezone_set('America/Sao_Paulo');
    $newDate = date("Y-m-d", strtotime($data));
    return $newDate;
}
