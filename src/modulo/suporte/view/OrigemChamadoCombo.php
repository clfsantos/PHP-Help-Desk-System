<?php

include '../../../seguranca.php';
include '../dao/OrigemChamadoDAO.php';

$origemChamadoDAO = new OrigemChamadoDAO();
$stmt = $origemChamadoDAO->origemChamadoCombo();

$items = array();
while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
    array_push($items, $row);
}

echo json_encode($items);
