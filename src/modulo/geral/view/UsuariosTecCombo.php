<?php

include '../../../seguranca.php';
include '../dao/UsuarioDAO.php';

$users = filter_input(INPUT_GET, "users") ? filter_input(INPUT_GET, "users") : '';

$usuarioDAO = new UsuarioDAO();
$stmt = $usuarioDAO->cbUsuariosTec();

$items = array();

if ($users === 'todos') {
    $vazio = array();
    $vazio['id'] = 0;
    $vazio['nome'] = 'Todos';
    array_push($items, $vazio);
}

while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
    array_push($items, $row);
}

echo json_encode($items);
