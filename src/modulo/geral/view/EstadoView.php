<?php

include '../../../seguranca.php';
include '../dao/EstadoDAO.php';

$paginaAtual = filter_input(INPUT_POST, "page") ? filter_input(INPUT_POST, "page") : 1;
$rows = filter_input(INPUT_POST, "rows") ? filter_input(INPUT_POST, "rows") : 10;
$busca = filter_input(INPUT_POST, "q") ? filter_input(INPUT_POST, "q") : '';
$sort = filter_input(INPUT_POST, "sort") ? filter_input(INPUT_POST, "sort") : 'nome';
$order = filter_input(INPUT_POST, "order") ? filter_input(INPUT_POST, "order") : 'asc';

$offset = ($paginaAtual - 1) * $rows;

$estadoDAO = new EstadoDAO();
$stmt = $estadoDAO->listar($busca, $offset, $rows, $sort, $order);

$result = array();
$result["total"] = $estadoDAO->contarBusca($busca);

$items = array();
while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
    array_push($items, $row);
}
$result["rows"] = $items;

echo json_encode($result);
