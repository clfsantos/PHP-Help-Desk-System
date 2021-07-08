<?php

include '../../../seguranca.php';
include '../dao/FluxoAtendimentoDAO.php';

$fluxoAtendimentoDAO = new FluxoAtendimentoDAO();
$stmt = $fluxoAtendimentoDAO->listarFluxo();

$result = array();
$items = array();
while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
    array_push($items, $row);
}
$result["rows"] = $items;

echo json_encode($result);