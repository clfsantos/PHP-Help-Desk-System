<?php

include '../../../seguranca.php';
include '../dao/ProdutoChamadoDAO.php';

$paginaAtual = filter_input(INPUT_POST, "page") ? filter_input(INPUT_POST, "page") : 1;
$rows = filter_input(INPUT_POST, "rows") ? filter_input(INPUT_POST, "rows") : 10;
$busca = filter_input(INPUT_POST, "q") ? filter_input(INPUT_POST, "q") : '';
$sort = filter_input(INPUT_POST, "sort") ? filter_input(INPUT_POST, "sort") : 'descricao';
$order = filter_input(INPUT_POST, "order") ? filter_input(INPUT_POST, "order") : 'asc';
$op = filter_input(INPUT_GET, "op");

$offset = ($paginaAtual - 1) * $rows;

$produtoDAO = new ProdutoChamadoDAO();

if ($op === 'dl') {
    $stmt = $produtoDAO->listarProdutos();

    $obj = array();
    $items = array();

    while ($row = $stmt->fetch()) {
        $obj = array("text" => $row['spchamado_produto_desc'], "id" => (int) $row['spchamado_produto_id']);
        array_push($items, $obj);
    }

    echo json_encode($items);
} elseif ($op === 'lista') {
    $stmt = $listaDAO->listar($busca, $offset, $rows, $sort, $order);

    $result = array();
    $result["total"] = $listaDAO->contarBusca($busca);

    $items = array();
    while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
        array_push($items, $row);
    }
    $result["rows"] = $items;

    echo json_encode($result);
}