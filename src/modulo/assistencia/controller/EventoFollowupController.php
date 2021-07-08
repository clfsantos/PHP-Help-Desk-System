<?php

include '../../../seguranca.php';
include '../model/EventoFollowup.class.php';
include '../dao/EventoFollowupDAO.php';

$idEvento = filter_input(INPUT_POST, "id_evento");
$descricaoEvento = filter_input(INPUT_POST, "descricao_evento");
$prioridadeID = filter_input(INPUT_POST, "prioridade_id");
$mensagem = array();

if (filter_input(INPUT_GET, "op") === 'cadastrar') {
    try {
        $eventoFollowup = new EventoFollowup();
        $eventoFollowup->setDescricaoEvento($descricaoEvento);
        $eventoFollowup->setPrioridadeID($prioridadeID);
        $eventoFollowupDAO = new EventoFollowupDAO();
        $eventoFollowupDAO->inserir($eventoFollowup);
        $mensagem["sucesso"] = "Incluído com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else if (filter_input(INPUT_GET, "op") === 'editar') {
    try {
        $eventoFollowup = new EventoFollowup();
        $eventoFollowup->setIdEvento($idEvento);
        $eventoFollowup->setDescricaoEvento($descricaoEvento);
        $eventoFollowup->setPrioridadeID($prioridadeID);
        $eventoFollowupDAO = new EventoFollowupDAO();
        $eventoFollowupDAO->atualizar($eventoFollowup);
        $mensagem["sucesso"] = "Atualizado com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else if (filter_input(INPUT_GET, "op") === 'excluir') {
    try {
        $eventoFollowup = new EventoFollowup();
        $eventoFollowup->setIdEvento($idEvento);
        $eventoFollowupDAO = new EventoFollowupDAO();
        $eventoFollowupDAO->excluir($eventoFollowup);
        $mensagem["sucesso"] = "Excluído com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else {
    $mensagem["erro"] = "Operação Inválida!";
}

echo json_encode($mensagem);
