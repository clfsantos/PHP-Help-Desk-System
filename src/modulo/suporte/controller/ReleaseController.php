<?php

include '../../../seguranca.php';
include '../model/Release.class.php';
include '../dao/ReleaseDAO.php';

$op = filter_input(INPUT_GET, "op");
$spchamado_release_id = filter_input(INPUT_POST, "spchamado_release_id");
$spchamado_produto_id = filter_input(INPUT_POST, "spchamado_produto_id");
$spchamado_release_num = filter_input(INPUT_POST, "spchamado_release_num");
$spchamado_release_desc = filter_input(INPUT_POST, "spchamado_release_desc");
$spchamado_release_dt = filter_input(INPUT_POST, "spchamado_release_dt_fmt");
$mensagem = array();

if ($op === 'cadastrar') {
    try {
        $release = new Release();
        $release->setSpchamado_produto_id($spchamado_produto_id);
        $release->setSpchamado_release_num($spchamado_release_num);
        $release->setSpchamado_release_desc($spchamado_release_desc);
        $release->setSpchamado_release_dt($spchamado_release_dt);
        $releaseDAO = new ReleaseDAO();
        $releaseDAO->inserir($release);
        $mensagem["sucesso"] = "Incluído com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} elseif ($op === 'editar') {
    try {
        $release = new Release();
        $release->setSpchamado_release_id($spchamado_release_id);
        $release->setSpchamado_produto_id($spchamado_produto_id);
        $release->setSpchamado_release_num($spchamado_release_num);
        $release->setSpchamado_release_desc($spchamado_release_desc);
        $release->setSpchamado_release_dt($spchamado_release_dt);
        $releaseDAO = new ReleaseDAO();
        $releaseDAO->atualizar($release);
        $mensagem["sucesso"] = "Editado com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} elseif ($op === 'excluir') {
    try {
        $release = new Release();
        $release->setSpchamado_release_id($spchamado_release_id);
        $releaseDAO = new ReleaseDAO();
        $releaseDAO->excluir($release);
        $mensagem["sucesso"] = "Excluído com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else {
    $mensagem["erro"] = "Operação Inválida!";
}

echo json_encode($mensagem);