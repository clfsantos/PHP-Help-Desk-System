<?php

include '../../../seguranca.php';
include '../model/SubGrupoChamado.class.php';
include '../dao/SubGrupoChamadoDAO.php';

$op = filter_input(INPUT_GET, "op");
$ide = filter_input(INPUT_POST, "ide");
$mensagem = array();

if (isset($_POST['dados'])) {
    $data = json_decode($_POST['dados']);
    $spchamado_subgrupo_id = $data[0]->value;
    $spchamado_subgrupo_desc = $data[1]->value;
}

if (isset($_POST['grupo_id'])) {
    $grupos = $_POST['grupo_id'];
} else {
    $grupos = "";
}

if ($op === 'cadastrar') {
    try {
        $subGrupo = new SubGrupoChamado();
        $subGrupo->setSpchamado_subgrupo_desc($spchamado_subgrupo_desc);
        $subGrupoDAO = new SubGrupoChamadoDAO();
        $subGrupoDAO->cadastrar($subGrupo, $grupos);
        $mensagem["sucesso"] = "Incluído com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} elseif ($op === 'editar') {
    try {
        $subGrupo = new SubGrupoChamado();
        $subGrupo->setSpchamado_subgrupo_id($spchamado_subgrupo_id);
        $subGrupo->setSpchamado_subgrupo_desc($spchamado_subgrupo_desc);
        $subGrupoDAO = new SubGrupoChamadoDAO();
        $subGrupoDAO->editar($subGrupo, $grupos);
        $mensagem["sucesso"] = "Editado com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} elseif ($op === 'excluir') {
    try {
        $subGrupo = new SubGrupoChamado();
        $subGrupo->setSpchamado_subgrupo_id($ide);
        $subGrupoDAO = new SubGrupoChamadoDAO();
        $subGrupoDAO->excluir($subGrupo);
        $mensagem["sucesso"] = "Excluído com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else {
    $mensagem["erro"] = "Operação Inválida!";
}

echo json_encode($mensagem);