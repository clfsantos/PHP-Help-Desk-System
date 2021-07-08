<?php

include '../../../seguranca.php';
include '../dao/ContatoDAO.php';

$paginaAtual = filter_input(INPUT_POST, "page") ? filter_input(INPUT_POST, "page") : 1;
$rows = filter_input(INPUT_POST, "rows") ? filter_input(INPUT_POST, "rows") : 10;
$busca = filter_input(INPUT_POST, "q") ? filter_input(INPUT_POST, "q") : '';
$buscaStatus = filter_input(INPUT_POST, "sc") ? filter_input(INPUT_POST, "sc") : '';
$sort = filter_input(INPUT_POST, "sort") ? filter_input(INPUT_POST, "sort") : 'id';
$order = filter_input(INPUT_POST, "order") ? filter_input(INPUT_POST, "order") : 'desc';
$op = filter_input(INPUT_GET, "op");

$offset = ($paginaAtual - 1) * $rows;

$contatoDAO = new ContatoDAO();

if ($op === 'contato') {
    $stmt = $contatoDAO->listar($busca, $buscaStatus, $offset, $rows, $sort, $order);

    $result = array();
    $result["total"] = $contatoDAO->contarBusca($busca, $buscaStatus);

    $items = array();
    while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
        array_push($items, $row);
    }
    $result["rows"] = $items;

    echo json_encode($result);
} elseif ($op === 'lista') {
    $contato_id = filter_input(INPUT_POST, "contato_id");
    $stmt = $contatoDAO->contatoLista($contato_id);

    $obj = array();
    $items = array();

    while ($row = $stmt->fetch()) {
        $obj = array("lista_id" => (int) $row['lista_id']);
        array_push($items, $obj);
    }

    echo json_encode($items);
} elseif ($op === 'listacontato') {
    $lista_id = filter_input(INPUT_GET, "lid");
    $stmt = $contatoDAO->contatosLista($busca, $offset, $rows, $sort, $order, $lista_id);

    $result = array();
    $result["total"] = $contatoDAO->contatosListaBusca($busca, $lista_id);

    $items = array();
    while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
        array_push($items, $row);
    }
    $result["rows"] = $items;

    echo json_encode($result);
}
