<?php

include '../../../seguranca.php';
include '../model/Cidade.class.php';
include '../dao/CidadeDAO.php';

$op = filter_input(INPUT_GET, "op");
$cidadeID = filter_input(INPUT_POST, "cidade_id");
$nome = filter_input(INPUT_POST, "cidade_nome");
$estadoID = filter_input(INPUT_POST, "estado_id");
$mensagem = array();

if ($op === 'cadastrar') {
    try {
        $cidade = new Cidade();
        $cidade->setNome($nome);
        $cidade->setEstadoID($estadoID);
        $cidadeDAO = new CidadeDAO();
        $cidadeDAO->cadastrar($cidade);
        $mensagem["sucesso"] = "Incluído com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} elseif ($op === 'editar') {
    try {
        $cidade = new Cidade();
        $cidade->setCidadeID($cidadeID);
        $cidade->setNome($nome);
        $cidade->setEstadoID($estadoID);
        $cidadeDAO = new CidadeDAO();
        $cidadeDAO->editar($cidade);
        $mensagem["sucesso"] = "Editado com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} elseif ($op === 'excluir') {
    try {
        $cidade = new Cidade();
        $cidade->setCidadeID($cidadeID);
        $cidadeDAO = new CidadeDAO();
        $cidadeDAO->excluir($cidade);
        $mensagem["sucesso"] = "Excluído com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else {
    $mensagem["erro"] = "Operação Inválida!";
}

echo json_encode($mensagem);
