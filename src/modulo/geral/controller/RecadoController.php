<?php

include '../../../seguranca.php';
include '../model/Recado.class.php';
include '../dao/RecadosDAO.php';

$recadoID = filter_input(INPUT_POST, "recado_id");
$empresa = filter_input(INPUT_POST, "recado_empresa");
$contato = filter_input(INPUT_POST, "recado_contato");
$departamento = filter_input(INPUT_POST, "recado_destino");
$recadoOBS = filter_input(INPUT_POST, "recado_desc");
$usuarioID = $_SESSION['usuarioID'];
$op = filter_input(INPUT_GET, "op");
$mensagem = array();

if ($op === 'salvar') {
    try {
        $recado = new Recado();
        $recado->setID($recadoID);
        $recado->setEmpresa($empresa);
        $recado->setContato($contato);
        $recado->setDepartamento($departamento);
        $recado->setRecadoOBS($recadoOBS);
        $recado->setUsuarioID($usuarioID);
        if (empty($recadoID)) {
            $recadoDAO = new RecadosDAO();
            $recadoDAO->cadastrar($recado);
            $mensagem["sucesso"] = "Incluído com Sucesso!";
            $mensagem["op"] = "I";
        } else {
            $recadoDAO = new RecadosDAO();
            $recadoDAO->editar($recado);
            $mensagem["sucesso"] = "Editado com Sucesso!";
            $mensagem["op"] = "E";
        }
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} elseif ($op === 'at') {
    try {
        $recado = new Recado();
        $recado->setID($recadoID);
        $recado->setUsuarioID($usuarioID);
        $recadoDAO = new RecadosDAO();
        $recadoDAO->atender($recado);
        $mensagem["sucesso"] = "Atendido com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} elseif ($op === 'mnat') {
    try {
        $recado = new Recado();
        $recado->setID($recadoID);
        $recadoDAO = new RecadosDAO();
        $recadoDAO->marcarNaoAtendido($recado);
        $mensagem["sucesso"] = "Desmarcado com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else {
    $mensagem["erro"] = "Operação Inválida!";
}

echo json_encode($mensagem);
