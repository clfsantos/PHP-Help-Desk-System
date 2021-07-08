<?php

include '../../../seguranca.php';
include '../dao/SubGrupoChamadoDAO.php';

$grupoID = filter_input(INPUT_GET, "gid") ? filter_input(INPUT_GET, "gid") : 0;

$subgrupoChamadoDAO = new SubGrupoChamadoDAO();
$stmt = $subgrupoChamadoDAO->subgrupoChamadoCombo($grupoID);

$items = array();
while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
    array_push($items, $row);
}

echo json_encode($items);
