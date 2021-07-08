<?php

include '../../seguranca.php';
include '../dao/CategoriaDAO.php';

$categoriaDAO = new CategoriaDAO();

$stmt = $categoriaDAO->listarCategorias();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$items = array();
$item = array();
$chs = array();
$ch = array();
foreach ($rows as $row) {
    $childs = $categoriaDAO->listarCategoriaParent($row['vdcategoria_id']);
    foreach ($childs as $child) {
        $ch = array("id" => (int) $child['vdcategoria_id'], "text" => $child['vdcategoria_nome']);
        array_push($chs, $ch);
    }
    $item = array("id" => (int) $row['vdcategoria_id'], "text" => $row['vdcategoria_nome'], "iconCls" => "clfs-icon-none", "children" => $chs);
    array_push($items, $item);
}

echo json_encode($items);
