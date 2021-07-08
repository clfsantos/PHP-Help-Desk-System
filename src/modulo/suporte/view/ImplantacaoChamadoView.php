<?php

include '../../../seguranca.php';
include '../dao/ImplantacaoChamadoDAO.php';

$id = filter_input(INPUT_GET, "id");
$paginaAtual = filter_input(INPUT_POST, "page") ? filter_input(INPUT_POST, "page") : 1;
$rows = filter_input(INPUT_POST, "rows") ? filter_input(INPUT_POST, "rows") : 10;
$sort = filter_input(INPUT_POST, "sort") ? filter_input(INPUT_POST, "sort") : 'id';
$order = filter_input(INPUT_POST, "order") ? filter_input(INPUT_POST, "order") : 'desc';

$offset = ($paginaAtual - 1) * $rows;

$implantacaoChamadoDAO = new ImplantacaoChamadoDAO();
$stmt = $implantacaoChamadoDAO->listar($id, $offset, $rows, $sort, $order);

$result = array();
$result["total"] = $implantacaoChamadoDAO->contarBusca($id);

$items = array();
while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
    array_push($items, $row);
}
$result["rows"] = $items;

echo json_encode($result);
