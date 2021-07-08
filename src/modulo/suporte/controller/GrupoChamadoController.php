<?php

include '../../../seguranca.php';
include '../model/GrupoChamado.class.php';
include '../dao/GrupoChamadoDAO.php';

$op = filter_input(INPUT_GET, "op");
$ide = filter_input(INPUT_POST, "ide");
$mensagem = array();

if (isset($_POST['dados'])) {
    $data = json_decode($_POST['dados']);
    $spchamado_grupo_id = $data[0]->value;
    $spchamado_grupo_desc = $data[1]->value;
}

if (isset($_POST['produto_id'])) {
    $produtos = $_POST['produto_id'];
} else {
    $produtos = "";
}

if ($op === 'cadastrar') {
    try {
        $grupo = new GrupoChamado();
        $grupo->setSpchamado_grupo_desc($spchamado_grupo_desc);
        $grupoDAO = new GrupoChamadoDAO();
        $grupoDAO->cadastrar($grupo, $produtos);
        $mensagem["sucesso"] = "Incluído com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} elseif ($op === 'editar') {
    try {
        $grupo = new GrupoChamado();
        $grupo->setSpchamado_grupo_id($spchamado_grupo_id);
        $grupo->setSpchamado_grupo_desc($spchamado_grupo_desc);
        $grupoDAO = new GrupoChamadoDAO();
        $grupoDAO->editar($grupo, $produtos);
        $mensagem["sucesso"] = "Editado com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} elseif ($op === 'excluir') {
    try {
        $grupo = new GrupoChamado();
        $grupo->setSpchamado_grupo_id($ide);
        $grupoDAO = new GrupoChamadoDAO();
        $grupoDAO->excluir($grupo);
        $mensagem["sucesso"] = "Excluído com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else {
    $mensagem["erro"] = "Operação Inválida!";
}

echo json_encode($mensagem);