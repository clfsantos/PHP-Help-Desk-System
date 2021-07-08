<?php

include '../../../seguranca.php';
include '../dao/DadosDAO.php';

$id = filter_input(INPUT_GET, "id");
$paginaAtual = filter_input(INPUT_POST, "page") ? filter_input(INPUT_POST, "page") : 1;
$rows = filter_input(INPUT_POST, "rows") ? filter_input(INPUT_POST, "rows") : 10;

$offset = ($paginaAtual - 1) * $rows;

$dadosDAO = new DadosDAO();
$stmt = $dadosDAO->listar($id, $offset, $rows);

$result = array();
$result["total"] = $dadosDAO->contarBusca($id);

$items = array();
while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
    array_push($items, $row);
}
$result["rows"] = $items;

echo json_encode($result);
