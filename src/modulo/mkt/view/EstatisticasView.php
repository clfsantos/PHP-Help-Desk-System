<?php

include '../../../seguranca.php';
include '../dao/EstatisticasDAO.php';

$paginaAtual = filter_input(INPUT_POST, "page") ? filter_input(INPUT_POST, "page") : 1;
$rows = filter_input(INPUT_POST, "rows") ? filter_input(INPUT_POST, "rows") : 10;
$busca = filter_input(INPUT_POST, "q") ? filter_input(INPUT_POST, "q") : '';
$sort = filter_input(INPUT_POST, "sort") ? filter_input(INPUT_POST, "sort") : 'qtdade';
$order = filter_input(INPUT_POST, "order") ? filter_input(INPUT_POST, "order") : 'desc';
$envio_id = filter_input(INPUT_GET, "eid") ? filter_input(INPUT_GET, "eid") : 0;
$status = filter_input(INPUT_POST, "status") ? filter_input(INPUT_POST, "status") : '';
$hora = filter_input(INPUT_POST, "hora") ? filter_input(INPUT_POST, "hora") : '';
$hora = substr($hora, 0, 2);

$offset = ($paginaAtual - 1) * $rows;

$estatisticasDAO = new EstatisticasDAO();
$result = array();

if ($status === 'Baixas') {
    $sort = 'dt_baixa';
    $stmt = $estatisticasDAO->listarStatus($busca, $offset, $rows, $sort, $order, $envio_id);
    $result["total"] = $estatisticasDAO->contarBuscaStatus($busca, $envio_id);
} else {
    $stmt = $estatisticasDAO->listar($busca, $offset, $rows, $sort, $order, $envio_id, $hora);
    $result["total"] = $estatisticasDAO->contarBusca($busca, $envio_id, $hora);
}

$items = array();
while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
    array_push($items, $row);
}
$result["rows"] = $items;

echo json_encode($result);
