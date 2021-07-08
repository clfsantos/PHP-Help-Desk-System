<?php

include '../../../seguranca.php';
include '../model/Categoria.class.php';
include '../dao/CategoriaDAO.php';

$id = filter_input(INPUT_POST, "id_categoria");
$descricao = filter_input(INPUT_POST, "descricao_categoria");
$mensagem = array();

if (filter_input(INPUT_GET, "op") === 'cadastrar') {
    try {
        $categoria = new Categoria();
        $categoria->setDescricao($descricao);
        $categoriaDAO = new CategoriaDAO();
        $categoriaDAO->inserir($categoria);
        $mensagem["sucesso"] = "Incluído com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else if (filter_input(INPUT_GET, "op") === 'editar') {
    try {
        $categoria = new Categoria();
        $categoria->setId($id);
        $categoria->setDescricao($descricao);
        $categoriaDAO = new CategoriaDAO();
        $categoriaDAO->atualizar($categoria);
        $mensagem["sucesso"] = "Atualizado com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else if (filter_input(INPUT_GET, "op") === 'excluir') {
    try {
        $categoria = new Categoria();
        $categoria->setId($id);
        $categoriaDAO = new CategoriaDAO();
        $categoriaDAO->excluir($categoria);
        $mensagem["sucesso"] = "Excluído com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else {
    $mensagem["erro"] = "Operação Inválida!";
}

echo json_encode($mensagem);
