<?php

include '../../../seguranca.php';
include '../model/Estado.class.php';
include '../dao/EstadoDAO.php';

$op = filter_input(INPUT_GET, "op");
$id = filter_input(INPUT_POST, "id");
$nome = filter_input(INPUT_POST, "nome");
$sigla = filter_input(INPUT_POST, "sigla");
$mensagem = array();

if ($op === 'cadastrar') {
    try {
        $estado = new Estado();
        $estado->setSigla($sigla);
        $estado->setNome($nome);
        $estadoDAO = new EstadoDAO();
        $estadoDAO->cadastrar($estado);
        $mensagem["sucesso"] = "Incluído com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} elseif ($op === 'editar') {
    try {
        $estado = new Estado();
        $estado->setId($id);
        $estado->setSigla($sigla);
        $estado->setNome($nome);
        $estadoDAO = new EstadoDAO();
        $estadoDAO->editar($estado);
        $mensagem["sucesso"] = "Editado com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} elseif ($op === 'excluir') {
    try {
        $estado = new Estado();
        $estado->setId($id);
        $estadoDAO = new EstadoDAO();
        $estadoDAO->excluir($estado);
        $mensagem["sucesso"] = "Excluído com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else {
    $mensagem["erro"] = "Operação Inválida!";
}

echo json_encode($mensagem);
