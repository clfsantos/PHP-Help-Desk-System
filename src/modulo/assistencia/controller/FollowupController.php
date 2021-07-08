<?php

include '../../../seguranca.php';
include '../model/Followup.class.php';
include '../dao/FollowupDAO.php';
include '../dao/EventoFollowupDAO.php';

$idFollowp = filter_input(INPUT_POST, "id_followup");
$idManutencao = filter_input(INPUT_POST, "assistencia_id");
$idEvento = filter_input(INPUT_POST, "id_evento");
$idUsuario = $_SESSION['usuarioID'];
$conteudo = filter_input(INPUT_POST, "followup_conteudo");
$enviar_email = filter_input(INPUT_POST, "enviar_email");
$mensagem = array();

if (filter_input(INPUT_GET, "op") === 'cadastrar') {
    try {
        $followup = new Followup();
        $followup->setIdManutencao($idManutencao);
        $followup->setIdEvento($idEvento);
        $followup->setIdUsuario($idUsuario);
        $followup->setConteudo($conteudo);
        $followupDAO = new FollowupDAO();
        $followupDAO->inserir($followup);
        $eventoFollowupDAO = new EventoFollowupDAO();
        $followup->setDescricaoEvento($eventoFollowupDAO->buscarEvento($followup->getIdEvento()));
        if(!empty($enviar_email)) {
            $followupDAO->enviarEmail($followup);
        }
        $mensagem["sucesso"] = "Incluído com Sucesso! - Foi enviado um e-mail ao cliente!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else if (filter_input(INPUT_GET, "op") === 'editar') {
    try {
        $followup = new Followup();
        $followup->setIdFollowp($idFollowp);
        $followup->setIdEvento($idEvento);
        $followup->setConteudo($conteudo);
        $followupDAO = new FollowupDAO();
        $followupDAO->atualizar($followup);
        $mensagem["sucesso"] = "Atualizado com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else if (filter_input(INPUT_GET, "op") === 'excluir') {
    try {
        $followup = new Followup();
        $followup->setIdFollowp($idFollowp);
        $followupDAO = new FollowupDAO();
        $followupDAO->excluir($followup);
        $mensagem["sucesso"] = "Excluído com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else {
    $mensagem["erro"] = "Operação Inválida!";
}

echo json_encode($mensagem);
