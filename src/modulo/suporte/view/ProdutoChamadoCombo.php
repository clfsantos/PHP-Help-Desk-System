<?php

include '../../../seguranca.php';
include '../dao/ProdutoChamadoDAO.php';

$produtoChamadoDAO = new ProdutoChamadoDAO();
$stmt = $produtoChamadoDAO->produtoChamadoCombo();

$items = array();
while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
    array_push($items, $row);
}

echo json_encode($items);
