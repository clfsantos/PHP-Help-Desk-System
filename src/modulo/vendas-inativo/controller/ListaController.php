<?php

include '../../seguranca.php';
include '../model/Lista.class.php';
include '../dao/ListaDAO.php';

$op = filter_input(INPUT_GET, "op");
$id = filter_input(INPUT_POST, "id");
$descricao = filter_input(INPUT_POST, "descricao");
$mensagem = array();

if ($op === 'cadastrar') {
    try {
        $lista = new Lista();
        $lista->setDescricao($descricao);
        $listaDAO = new ListaDAO();
        $listaDAO->cadastrar($lista);
        $mensagem["sucesso"] = "Incluído com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} elseif ($op === 'editar') {
    try {
        $lista = new Lista();
        $lista->setId($id);
        $lista->setDescricao($descricao);
        $listaDAO = new ListaDAO();
        $listaDAO->editar($lista);
        $mensagem["sucesso"] = "Editado com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} elseif ($op === 'excluir') {
    try {
        $lista = new Lista();
        $lista->setId($id);
        $listaDAO = new ListaDAO();
        $listaDAO->excluir($lista);
        $mensagem["sucesso"] = "Excluído com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else {
    $mensagem["erro"] = "Operação Inválida!";
}

echo json_encode($mensagem);
