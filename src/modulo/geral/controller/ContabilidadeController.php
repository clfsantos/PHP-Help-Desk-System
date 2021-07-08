<?php

include '../../../seguranca.php';
include '../model/Contabilidade.class.php';
include '../dao/ContabilidadeDAO.php';

$op = filter_input(INPUT_GET, "op");
$id = filter_input(INPUT_POST, "contabilidade_id");
$cnpj = filter_input(INPUT_POST, "contabilidade_cnpj");
$nome = filter_input(INPUT_POST, "contabilidade_nome");
$contato = filter_input(INPUT_POST, "contabilidade_contato");
$email = filter_input(INPUT_POST, "contabilidade_email");
$telefone = filter_input(INPUT_POST, "contabilidade_telefone");
$obs = filter_input(INPUT_POST, "contabilidade_obs");
$mensagem = array();

if ($op === 'cadastrar') {
    try {
        $contabilidade = new Contabilidade();
        $contabilidade->setCnpj($cnpj);
        $contabilidade->setNome($nome);
		$contabilidade->setContato($contato);
		$contabilidade->setEmail($email);
		$contabilidade->setTelefone($telefone);
		$contabilidade->setObs($obs);
        $contabilidadeDAO = new ContabilidadeDAO();
        $contabilidadeDAO->cadastrar($contabilidade);
        $mensagem["sucesso"] = "Incluído com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} elseif ($op === 'editar') {
    try {
        $contabilidade = new Contabilidade();
        $contabilidade->setContabilidadeID($id);
		$contabilidade->setCnpj($cnpj);
        $contabilidade->setNome($nome);
		$contabilidade->setContato($contato);
		$contabilidade->setEmail($email);
		$contabilidade->setTelefone($telefone);
		$contabilidade->setObs($obs);
        $contabilidadeDAO = new ContabilidadeDAO();
        $contabilidadeDAO->editar($contabilidade);
        $mensagem["sucesso"] = "Editado com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} elseif ($op === 'excluir') {
    try {
        $contabilidade = new Contabilidade();
        $contabilidade->setContabilidadeID($id);
        $contabilidadeDAO = new ContabilidadeDAO();
        $contabilidadeDAO->excluir($contabilidade);
        $mensagem["sucesso"] = "Excluído com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else {
    $mensagem["erro"] = "Operação Inválida!";
}

echo json_encode($mensagem);
