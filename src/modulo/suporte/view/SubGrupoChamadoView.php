<?php

include '../../../seguranca.php';
include '../dao/SubGrupoChamadoDAO.php';

$paginaAtual = filter_input(INPUT_POST, "page") ? filter_input(INPUT_POST, "page") : 1;
$rows = filter_input(INPUT_POST, "rows") ? filter_input(INPUT_POST, "rows") : 10;
$busca = filter_input(INPUT_POST, "q") ? filter_input(INPUT_POST, "q") : '';
$sort = filter_input(INPUT_POST, "sort") ? filter_input(INPUT_POST, "sort") : 'spchamado_subgrupo_desc';
$order = filter_input(INPUT_POST, "order") ? filter_input(INPUT_POST, "order") : 'asc';
$op = filter_input(INPUT_GET, "op");

$offset = ($paginaAtual - 1) * $rows;

$subGrupoDAO = new SubGrupoChamadoDAO();

if ($op === 'subgrupos') {
    $stmt = $subGrupoDAO->listar($busca, $offset, $rows, $sort, $order);

    $result = array();
    $result["total"] = $subGrupoDAO->contarBusca($busca);

    $items = array();
    while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
        array_push($items, $row);
    }
    $result["rows"] = $items;

    echo json_encode($result);
} elseif ($op === 'lista') {
    $subgrupo_id = filter_input(INPUT_POST, "subgrupo_id");
    $stmt = $subGrupoDAO->subGrupoLista($subgrupo_id);

    $obj = array();
    $items = array();

    while ($row = $stmt->fetch()) {
        $obj = array("spchamado_grupo_id" => (int) $row['spchamado_grupo_id']);
        array_push($items, $obj);
    }

    echo json_encode($items);
}