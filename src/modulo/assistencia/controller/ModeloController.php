<?php

include '../../../seguranca.php';
include '../model/Modelo.class.php';
include '../dao/ModeloDAO.php';

$codigo = filter_input(INPUT_POST, "id_modelo");
$codigoFabricante = filter_input(INPUT_POST, "codigo_fabricante");
$idCategoria = filter_input(INPUT_POST, "id_categoria");
$descricao = filter_input(INPUT_POST, "descricao");
$mensagem = array();

if (filter_input(INPUT_GET, "op") === 'cadastrar') {
    try {
        $modelo = new Modelo();
        $modelo->setDescricao($descricao);
        $modelo->setCodigoFabricante($codigoFabricante);
        $modelo->setIdCategoria($idCategoria);
        $modeloDAO = new ModeloDAO();
        $modeloDAO->inserir($modelo);
        $mensagem["sucesso"] = "Incluído com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else if (filter_input(INPUT_GET, "op") === 'editar') {
    try {
        $modelo = new Modelo();
        $modelo->setCodigo($codigo);
        $modelo->setDescricao($descricao);
        $modelo->setCodigoFabricante($codigoFabricante);
        $modelo->setIdCategoria($idCategoria);
        $modeloDAO = new ModeloDAO();
        $modeloDAO->atualizar($modelo);
        $mensagem["sucesso"] = "Atualizado com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else if (filter_input(INPUT_GET, "op") === 'excluir') {
    try {
        $modelo = new Modelo();
        $modelo->setCodigo($codigo);
        $modeloDAO = new ModeloDAO();
        $modeloDAO->excluir($modelo);
        $mensagem["sucesso"] = "Excluído com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else {
    $mensagem["erro"] = "Operação Inválida!";
}

echo json_encode($mensagem);
