<?php

include '../../../seguranca.php';
include '../dao/ClassificacaoChamadoDAO.php';

$classificacaoChamadoDAO = new ClassificacaoChamadoDAO();
$stmt = $classificacaoChamadoDAO->classificacaoChamadoCombo();

$items = array();
while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
    array_push($items, $row);
}

echo json_encode($items);
