<?php

include '../../../seguranca.php';
include '../model/TarefaChamado.class.php';
include '../dao/TarefaChamadoDAO.php';
include '../dao/ChamadoDAO.php';

$chamadoID = filter_input(INPUT_POST, "spchamado_id");
$tarefaID = filter_input(INPUT_POST, "sptarefa_id");
$dtTarefa = filter_input(INPUT_POST, "sptarefa_dt_tarefa");
$duracao = filter_input(INPUT_POST, "sptarefa_duracao");
$usuarioAtribuicao = filter_input(INPUT_POST, "sptarefa_u_atribuido");
$usuarioID = $_SESSION['usuarioID'];
$titulo = filter_input(INPUT_POST, "sptarefa_titulo");
$descricao = filter_input(INPUT_POST, "sptarefa_desc");
$status = filter_input(INPUT_POST, "sptarefa_status");
if($status === '2') {
    $cancelada = 'true';
    $status = 'true';
} else {
    $cancelada = 'false';
}
if(filter_input(INPUT_POST, "spchamado_transferir")) {
    $transferir = true;
} else {
    $transferir = false;
}

$mensagem = array();

$op = filter_input(INPUT_GET, "op");
if ($op === 'excluir') {
    $op = 'excluir';
} elseif (!empty($tarefaID)) {
    $op = 'editar';
} else {
    $op = 'cadastrar';
}

if ($op === 'cadastrar') {
    try {
        $tarefaChamado = new TarefaChamado();
        $tarefaChamado->setChamadoID($chamadoID);
        $tarefaChamado->setDtTarefa($dtTarefa);
        $tarefaChamado->setDuracao($duracao);
        $tarefaChamado->setUsuarioAtribuicao($usuarioAtribuicao);
        $tarefaChamado->setUsuarioID($usuarioID);
        $tarefaChamado->setTitulo($titulo);
        $tarefaChamado->setDescricao($descricao);
        $tarefaChamado->calculaVencimento($tarefaChamado->getDtTarefa(), $tarefaChamado->getDuracao());
        $tarefaChamadoDAO = new TarefaChamadoDAO();
        $tarefaChamadoDAO->inserir($tarefaChamado);
        if ($transferir) {
            try {
                $chamadoDAO = new ChamadoDAO();
                $chamadoDAO->trocaUsuarioAtual($usuarioAtribuicao, $chamadoID);
            } catch (Exception $ex) {
                $mensagem["erro"] = $ex->getMessage();
                $mensagem["errocod"] = $ex->getCode();
            }
        }
        $mensagem["sucesso"] = "Incluído com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else if ($op === 'editar') {
    try {
        $tarefaChamado = new TarefaChamado();
        $tarefaChamado->setChamadoID($chamadoID);
        $tarefaChamado->setTarefaID($tarefaID);
        $tarefaChamado->setDtTarefa($dtTarefa);
        $tarefaChamado->setDuracao($duracao);
        $tarefaChamado->setUsuarioAtribuicao($usuarioAtribuicao);
        $tarefaChamado->setUsuarioID($usuarioID);
        $tarefaChamado->setTitulo($titulo);
        $tarefaChamado->setDescricao($descricao);
        $tarefaChamado->setStatus($status);
        $tarefaChamado->setCancelada($cancelada);
        $tarefaChamado->calculaVencimento($tarefaChamado->getDtTarefa(), $tarefaChamado->getDuracao());
        $tarefaChamadoDAO = new TarefaChamadoDAO();
        $tarefaChamadoDAO->atualizar($tarefaChamado);
        if ($transferir) {
            try {
                $chamadoDAO = new ChamadoDAO();
                $chamadoDAO->trocaUsuarioAtual($usuarioAtribuicao, $chamadoID);
            } catch (Exception $ex) {
                $mensagem["erro"] = $ex->getMessage();
                $mensagem["errocod"] = $ex->getCode();
            }
        }
        $mensagem["sucesso"] = "Atualizado com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else if ($op === 'excluir') {
    try {
        $tarefaChamado = new TarefaChamado();
        $tarefaChamado->setTarefaID($tarefaID);
        $tarefaChamadoDAO = new TarefaChamadoDAO();
        $tarefaChamadoDAO->excluir($tarefaChamado);
        $mensagem["sucesso"] = "Cancelado com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else {
    $mensagem["erro"] = "Operação Inválida!";
}

echo json_encode($mensagem);
