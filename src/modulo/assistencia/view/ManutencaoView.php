<?php

include '../../../seguranca.php';
include '../dao/ManutencaoDAO.php';

$paginaAtual = filter_input(INPUT_POST, "page") ? filter_input(INPUT_POST, "page") : 1;
$rows = filter_input(INPUT_POST, "rows") ? filter_input(INPUT_POST, "rows") : 10;
$busca = filter_input(INPUT_POST, "q") ? filter_input(INPUT_POST, "q") : '';
$buscapm = filter_input(INPUT_POST, "pm") ? filter_input(INPUT_POST, "pm") : 'aberto';
$sort = filter_input(INPUT_POST, "sort") ? filter_input(INPUT_POST, "sort") : 'id_manutencao';
$order = filter_input(INPUT_POST, "order") ? filter_input(INPUT_POST, "order") : 'desc';

$offset = ($paginaAtual - 1) * $rows;

$ManutencaoDAO = new ManutencaoDAO();
$stmt = $ManutencaoDAO->listar($buscapm, $busca, $offset, $rows, $sort, $order);

$result = array();
$result["total"] = $ManutencaoDAO->contarBusca($buscapm, $busca);

$items = array();
while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
    array_push($items, $row);
}
$result["rows"] = $items;

echo json_encode($result);
