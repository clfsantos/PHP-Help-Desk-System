<?php

include '../../../seguranca.php';
include '../dao/ReleaseDAO.php';

$produtoID = filter_input(INPUT_GET, "produtoid") ? filter_input(INPUT_GET, "produtoid") : 2;

$releaseDAO = new ReleaseDAO();
$stmt = $releaseDAO->releaseCombo($produtoID);

$items = array();
while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
    array_push($items, $row);
}

echo json_encode($items);
