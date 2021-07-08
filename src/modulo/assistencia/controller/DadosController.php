<?php

include '../../../seguranca.php';
include '../model/Dados.class.php';
include '../dao/DadosDAO.php';

$idManutencao = filter_input(INPUT_POST, "id_manutencao");
$nrIP = filter_input(INPUT_POST, "nr_ip");
$mascara = filter_input(INPUT_POST, "mascara");
$gateway = filter_input(INPUT_POST, "gateway");
if (filter_input(INPUT_POST, "bateria")) {
    $bateria = 1;
} else {
    $bateria = 0;
}
if (filter_input(INPUT_POST, "chave")) {
    $chave = 1;
} else {
    $chave = 0;
}
if (filter_input(INPUT_POST, "bobina")) {
    $bobina = 1;
} else {
    $bobina = 0;
}
$outros = filter_input(INPUT_POST, "outros");
$lacre_antigo = filter_input(INPUT_POST, "lacre_antigo");
$lacre_novo = filter_input(INPUT_POST, "lacre_novo");
$novo_nsr = filter_input(INPUT_POST, "novo_nsr");
$op = filter_input(INPUT_GET, "op");

$mensagem = array();

if ($op === "desvincular") {
    $dadosDAO = new DadosDAO();
    $dadosDAO->desvincular($idManutencao);
    $mensagem["sucesso"] = "Dados Desvinculados com Sucesso";
} else {
    try {
        $dados = new Dados();
        $dados->setIdManutencao($idManutencao);
        $dados->setNrIP($nrIP);
        $dados->setMascara($mascara);
        $dados->setGateway($gateway);
        $dados->setBateria($bateria);
        $dados->setChave($chave);
        $dados->setBobina($bobina);
        $dados->setOutros($outros);
        $dados->setLacreAntigo($lacre_antigo);
        $dados->setLacreNovo($lacre_novo);
        $dados->setNovoNSR($novo_nsr);
        $dadosDAO = new DadosDAO();
        $dadosDAO->salvar($dados);
        $mensagem["sucesso"] = "Salvo com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
}

echo json_encode($mensagem);
