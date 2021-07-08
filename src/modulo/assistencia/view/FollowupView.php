<?php

include '../../../seguranca.php';
include '../dao/FollowupDAO.php';

$id = filter_input(INPUT_GET, "id");
$paginaAtual = filter_input(INPUT_POST, "page") ? filter_input(INPUT_POST, "page") : 1;
$rows = filter_input(INPUT_POST, "rows") ? filter_input(INPUT_POST, "rows") : 10;
$sort = filter_input(INPUT_POST, "sort") ? filter_input(INPUT_POST, "sort") : 'id_followup';
$order = filter_input(INPUT_POST, "order") ? filter_input(INPUT_POST, "order") : 'asc';

$offset = ($paginaAtual - 1) * $rows;

$followupDAO = new FollowupDAO();
$stmt = $followupDAO->listar($id, $offset, $rows, $sort, $order);

$result = array();
$result["total"] = $followupDAO->contarBusca($id);

$items = array();
while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
    array_push($items, $row);
}
$result["rows"] = $items;

echo json_encode($result);
