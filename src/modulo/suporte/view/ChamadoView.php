<?php

include '../../../seguranca.php';
include '../dao/ChamadoDAO.php';

$paginaAtual = filter_input(INPUT_POST, "page") ? filter_input(INPUT_POST, "page") : 1;
$rows = filter_input(INPUT_POST, "rows") ? filter_input(INPUT_POST, "rows") : 10;
$busca = filter_input(INPUT_POST, "q") ? filter_input(INPUT_POST, "q") : '';
$status = filter_input(INPUT_POST, "status") ? filter_input(INPUT_POST, "status") : '';
$user = filter_input(INPUT_POST, "user") ? filter_input(INPUT_POST, "user") : '';
$sort = filter_input(INPUT_POST, "sort") ? filter_input(INPUT_POST, "sort") : 'spchamado_id';
$order = filter_input(INPUT_POST, "order") ? filter_input(INPUT_POST, "order") : 'desc';

$offset = ($paginaAtual - 1) * $rows;

$chamadoDAO = new ChamadoDAO();
$stmt = $chamadoDAO->listar($busca, $offset, $rows, $sort, $order, $user, $status);

$result = array();
$result["total"] = $chamadoDAO->contarBusca($busca, $user, $status);

$items = array();
while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
    array_push($items, $row);
}
$result["rows"] = $items;

echo json_encode($result);
