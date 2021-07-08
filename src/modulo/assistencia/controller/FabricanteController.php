<?php

include '../../../seguranca.php';
include '../model/Fabricante.class.php';
include '../dao/FabricanteDAO.php';

$codigo = filter_input(INPUT_POST, "codigo_fabricante");
$nome = filter_input(INPUT_POST, "nome_fabricante");
$mensagem = array();

if (filter_input(INPUT_GET, "op") === 'cadastrar') {
    try {
        $fabricante = new Fabricante();
        $fabricante->setNome($nome);
        $fabricanteDAO = new FabricanteDAO();
        $fabricanteDAO->inserir($fabricante);
        $mensagem["sucesso"] = "Incluído com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else if (filter_input(INPUT_GET, "op") === 'editar') {
    try {
        $fabricante = new Fabricante();
        $fabricante->setCodigo($codigo);
        $fabricante->setNome($nome);
        $fabricanteDAO = new FabricanteDAO();
        $fabricanteDAO->atualizar($fabricante);
        $mensagem["sucesso"] = "Atualizado com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else if (filter_input(INPUT_GET, "op") === 'excluir') {
    try {
        $fabricante = new Fabricante();
        $fabricante->setCodigo($codigo);
        $fabricanteDAO = new FabricanteDAO();
        $fabricanteDAO->excluir($fabricante);
        $mensagem["sucesso"] = "Excluído com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else {
    $mensagem["erro"] = "Operação Inválida!";
}

echo json_encode($mensagem);
