<?php

include '../../../seguranca.php';
include '../dao/GrupoChamadoDAO.php';

$produtoID = filter_input(INPUT_GET, "pid") ? filter_input(INPUT_GET, "pid") : 0;

$grupoChamadoDAO = new GrupoChamadoDAO();
$stmt = $grupoChamadoDAO->grupoChamadoCombo($produtoID);

$items = array();
while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
    array_push($items, $row);
}

echo json_encode($items);
