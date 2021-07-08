<?php

include '../../../seguranca.php';
include '../model/Manutencao.class.php';
include '../dao/ManutencaoDAO.php';

$idManutencao = filter_input(INPUT_POST, "id_manutencao");
$codigoEquipamento = filter_input(INPUT_POST, "codigo_equipamento");
$idProblema = filter_input(INPUT_POST, "id_problema");
$problemaInicial = filter_input(INPUT_POST, "problema_inicial");
$dataEntrada = filter_input(INPUT_POST, "data_entrada");
$dataSaida = filter_input(INPUT_POST, "data_devolucao");
$laudoTecnico = filter_input(INPUT_POST, "laudo_tecnico");
$notaFiscal = filter_input(INPUT_POST, "nota_fiscal");
if (filter_input(INPUT_POST, "manutencao_ativa")) {
    $manutencaoAtiva = 0;
} else {
    $manutencaoAtiva = 1;
}

$mensagem = array();

if (filter_input(INPUT_GET, "op") === 'cadastrar') {
    try {
        $manutencao = new Manutencao();
        $manutencao->setCodigoEquipamento($codigoEquipamento);
        $manutencao->setIdProblema($idProblema);
        $manutencao->setProblemaInicial($problemaInicial);
        $manutencao->setDataEntrada($dataEntrada);
        $manutencao->setDataSaida($dataSaida);
        $manutencao->setLaudoTecnico($laudoTecnico);
        $manutencao->setManutencaoAtiva($manutencaoAtiva);
        $manutencao->setNotaFiscal($notaFiscal);
        $manutencaoDAO = new ManutencaoDAO();
        $manutencaoDAO->inserir($manutencao);
        $mensagem["sucesso"] = "Incluído com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else if (filter_input(INPUT_GET, "op") === 'editar') {
    try {
        $manutencao = new Manutencao();
        $manutencao->setIdManutencao($idManutencao);
        $manutencao->setCodigoEquipamento($codigoEquipamento);
        $manutencao->setIdProblema($idProblema);
        $manutencao->setProblemaInicial($problemaInicial);
        $manutencao->setDataEntrada($dataEntrada);
        $manutencao->setDataSaida($dataSaida);
        $manutencao->setLaudoTecnico($laudoTecnico);
        $manutencao->setManutencaoAtiva($manutencaoAtiva);
        $manutencao->setNotaFiscal($notaFiscal);
        $manutencaoDAO = new ManutencaoDAO();
        $manutencaoDAO->atualizar($manutencao);
        $mensagem["sucesso"] = "Atualizado com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else if (filter_input(INPUT_GET, "op") === 'excluir') {
    try {
        $manutencao = new Manutencao();
        $manutencao->setIdManutencao($idManutencao);
        $manutencaoDAO = new ManutencaoDAO();
        $manutencaoDAO->excluir($manutencao);
        $mensagem["sucesso"] = "Excluído com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else {
    $mensagem["erro"] = "Operação Inválida!";
}

echo json_encode($mensagem);
