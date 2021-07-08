<?php

include '../../../seguranca.php';
include '../model/ProblemaManutencao.class.php';
include '../dao/ProblemaManutencaoDAO.php';

$idProblema = filter_input(INPUT_POST, "id_problema");
$descricaoProblema = filter_input(INPUT_POST, "descricao_problema");
$mensagem = array();

if (filter_input(INPUT_GET, "op") === 'cadastrar') {
    try {
        $problemaManutencao = new ProblemaManutencao();
        $problemaManutencao->setDescricaoProblema($descricaoProblema);
        $problemaManutencaoDAO = new ProblemaManutencaoDAO();
        $problemaManutencaoDAO->inserir($problemaManutencao);
        $mensagem["sucesso"] = "Incluído com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else if (filter_input(INPUT_GET, "op") === 'editar') {
    try {
        $problemaManutencao = new ProblemaManutencao();
        $problemaManutencao->setIdProblema($idProblema);
        $problemaManutencao->setDescricaoProblema($descricaoProblema);
        $problemaManutencaoDAO = new ProblemaManutencaoDAO();
        $problemaManutencaoDAO->atualizar($problemaManutencao);
        $mensagem["sucesso"] = "Atualizado com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else if (filter_input(INPUT_GET, "op") === 'excluir') {
    try {
        $problemaManutencao = new ProblemaManutencao();
        $problemaManutencao->setIdProblema($idProblema);
        $problemaManutencaoDAO = new ProblemaManutencaoDAO();
        $problemaManutencaoDAO->excluir($problemaManutencao);
        $mensagem["sucesso"] = "Excluído com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else {
    $mensagem["erro"] = "Operação Inválida!";
}

echo json_encode($mensagem);
