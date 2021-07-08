<?php

include '../../../seguranca.php';
include '../model/Equipamento.class.php';
include '../dao/EquipamentoDAO.php';

$codigo = filter_input(INPUT_POST, "codigo_equipamento");
$nrSerie = filter_input(INPUT_POST, "nr_serie");
$codigoEmpresa = filter_input(INPUT_POST, "crcliente_id");
$idModelo = filter_input(INPUT_POST, "id_modelo");
if (filter_input(INPUT_POST, "teste_ok")) {
    $testeOk = 1;
} else {
    $testeOk = 0;
}
if (filter_input(INPUT_POST, "inativo")) {
    $inativo = 1;
} else {
    $inativo = 0;
}
$mensagem = array();

if (filter_input(INPUT_GET, "op") === 'cadastrar') {
    try {
        $equipamento = new Equipamento();
        $equipamento->setNrSerie($nrSerie);
        $equipamento->setCodigoEmpresa($codigoEmpresa);
        $equipamento->setIdModelo($idModelo);
        $equipamento->setTesteOK($testeOk);
        $equipamento->setInativo($inativo);
        $equipamentoDAO = new EquipamentoDAO();
        $equipamentoDAO->inserir($equipamento);
        $mensagem["sucesso"] = "Incluído com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else if (filter_input(INPUT_GET, "op") === 'editar') {
    try {
        $equipamento = new Equipamento();
        $equipamento->setCodigo($codigo);
        $equipamento->setNrSerie($nrSerie);
        $equipamento->setCodigoEmpresa($codigoEmpresa);
        $equipamento->setIdModelo($idModelo);
        $equipamento->setTesteOK($testeOk);
        $equipamento->setInativo($inativo);
        $equipamentoDAO = new EquipamentoDAO();
        $equipamentoDAO->atualizar($equipamento);
        $mensagem["sucesso"] = "Atualizado com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else if (filter_input(INPUT_GET, "op") === 'excluir') {
    try {
        $equipamento = new Equipamento();
        $equipamento->setCodigo($codigo);
        $equipamentoDAO = new EquipamentoDAO();
        $equipamentoDAO->excluir($equipamento);
        $mensagem["sucesso"] = "Excluído com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else {
    $mensagem["erro"] = "Operação Inválida!";
}

echo json_encode($mensagem);
