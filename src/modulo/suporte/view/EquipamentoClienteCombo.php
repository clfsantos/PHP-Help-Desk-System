<?php

include '../../../seguranca.php';
include '../dao/ChamadoDAO.php';

$clienteID = filter_input(INPUT_GET, "clienteid") ? filter_input(INPUT_GET, "clienteid") : 0;

$chamadoDAO = new ChamadoDAO();
$stmt = $chamadoDAO->equipamentoClienteCombo($clienteID);

$items = array();
while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
    array_push($items, $row);
}

echo json_encode($items);