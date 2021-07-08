<?php

include '../../../seguranca.php';
include '../dao/GrupoChamadoDAO.php';

$paginaAtual = filter_input(INPUT_POST, "page") ? filter_input(INPUT_POST, "page") : 1;
$rows = filter_input(INPUT_POST, "rows") ? filter_input(INPUT_POST, "rows") : 10;
$busca = filter_input(INPUT_POST, "q") ? filter_input(INPUT_POST, "q") : '';
$sort = filter_input(INPUT_POST, "sort") ? filter_input(INPUT_POST, "sort") : 'spchamado_grupo_desc';
$order = filter_input(INPUT_POST, "order") ? filter_input(INPUT_POST, "order") : 'asc';
$op = filter_input(INPUT_GET, "op");

$offset = ($paginaAtual - 1) * $rows;

$grupoDAO = new GrupoChamadoDAO();

if ($op === 'grupos') {
    $stmt = $grupoDAO->listar($busca, $offset, $rows, $sort, $order);

    $result = array();
    $result["total"] = $grupoDAO->contarBusca($busca);

    $items = array();
    while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
        array_push($items, $row);
    }
    $result["rows"] = $items;

    echo json_encode($result);
} elseif ($op === 'lista') {
    $grupo_id = filter_input(INPUT_POST, "grupo_id");
    $stmt = $grupoDAO->grupoLista($grupo_id);

    $obj = array();
    $items = array();

    while ($row = $stmt->fetch()) {
        $obj = array("spchamado_produto_id" => (int) $row['spchamado_produto_id']);
        array_push($items, $obj);
    }

    echo json_encode($items);
} elseif ($op === 'dl') {
    $stmt = $grupoDAO->listarGrupos();

    $obj = array();
    $items = array();

    while ($row = $stmt->fetch()) {
        $obj = array("text" => $row['spchamado_grupo_desc'], "id" => (int) $row['spchamado_grupo_id']);
        array_push($items, $obj);
    }

    echo json_encode($items);
}