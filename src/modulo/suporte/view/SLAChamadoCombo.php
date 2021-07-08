<?php

include '../../../seguranca.php';
include '../dao/ChamadoDAO.php';

$chamadoDAO = new ChamadoDAO();
$stmt = $chamadoDAO->slaChamadoCombo();

$items = array();
while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
    array_push($items, $row);
}

echo json_encode($items);