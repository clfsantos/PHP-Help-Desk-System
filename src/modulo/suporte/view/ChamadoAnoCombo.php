<?php

include '../../../seguranca.php';
include '../dao/ChamadoDAO.php';

$anoChamadoDAO = new ChamadoDAO();
$stmt = $anoChamadoDAO->anoChamadoCombo();

$items = array();
while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
    array_push($items, $row);
}

echo json_encode($items);
