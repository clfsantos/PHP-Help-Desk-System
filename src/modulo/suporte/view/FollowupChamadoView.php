<?php

include '../../../seguranca.php';
include '../dao/FollowupChamadoDAO.php';

$id = filter_input(INPUT_GET, "id");
$paginaAtual = filter_input(INPUT_POST, "page") ? filter_input(INPUT_POST, "page") : 1;
$rows = filter_input(INPUT_POST, "rows") ? filter_input(INPUT_POST, "rows") : 10;
$sort = filter_input(INPUT_POST, "sort") ? filter_input(INPUT_POST, "sort") : 'spfollowup_id';
$order = filter_input(INPUT_POST, "order") ? filter_input(INPUT_POST, "order") : 'desc';

$offset = ($paginaAtual - 1) * $rows;

$followupChamadoDAO = new FollowupChamadoDAO();
$stmt = $followupChamadoDAO->listar($id, $offset, $rows, $sort, $order);

$result = array();
$result["total"] = $followupChamadoDAO->contarBusca($id);

$items = array();
while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
    array_push($items, $row);
}
$result["rows"] = $items;

echo json_encode($result);
