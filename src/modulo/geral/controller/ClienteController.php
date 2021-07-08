<?php

include '../../../seguranca.php';
include '../model/CRCliente.class.php';
include '../dao/CRClienteDAO.php';

$op = filter_input(INPUT_GET, "op");
$crclienteId = filter_input(INPUT_POST, "crcliente_id");
$crclienteBloqueado = filter_input(INPUT_POST, "crcliente_bloqueado");
$crclienteCelular = filter_input(INPUT_POST, "rcliente_celular");
$crclienteEmailRH = filter_input(INPUT_POST, "crcliente_email_rh");
$crclienteOBS = filter_input(INPUT_POST, "crcliente_obs");
$contabilidadeId = filter_input(INPUT_POST, "contabilidade_id");
$mensagem = array();

if ($op === 'editar') {
    try {
        $cliente = new CRCliente();
        $cliente->setCrclienteId($crclienteId);
        $cliente->setCrclienteBloqueado($crclienteBloqueado);
		$cliente->setCrClienteCelular($crclienteCelular);
		$cliente->setCrClienteEmailRH($crclienteEmailRH);
        $cliente->setCrclienteOBS($crclienteOBS);
		$cliente->setContabilidadeId($contabilidadeId);
        $clienteDAO = new CRClienteDAO();
        $clienteDAO->editar($cliente);
        $mensagem["sucesso"] = "Editado com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else {
    $mensagem["erro"] = "Operação Inválida!";
}

echo json_encode($mensagem);
