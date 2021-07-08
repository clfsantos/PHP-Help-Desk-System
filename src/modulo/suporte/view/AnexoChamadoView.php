<?php

include '../../../seguranca.php';
include '../dao/AnexoChamadoDAO.php';

$id = filter_input(INPUT_GET, "id");
$paginaAtual = filter_input(INPUT_POST, "page") ? filter_input(INPUT_POST, "page") : 1;
$rows = filter_input(INPUT_POST, "rows") ? filter_input(INPUT_POST, "rows") : 10;
$sort = filter_input(INPUT_POST, "sort") ? filter_input(INPUT_POST, "sort") : 'spanexo_id';
$order = filter_input(INPUT_POST, "order") ? filter_input(INPUT_POST, "order") : 'desc';

$offset = ($paginaAtual - 1) * $rows;

$anexoChamadoDAO = new AnexoChamadoDAO();
$stmt = $anexoChamadoDAO->listar($id, $offset, $rows, $sort, $order);

$result = array();
$result["total"] = $anexoChamadoDAO->contarBusca($id);

$items = array();
while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
    array_push($items, $row);
}
$result["rows"] = $items;

echo json_encode($result);
