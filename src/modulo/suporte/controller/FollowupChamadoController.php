<?php

include '../../../seguranca.php';
include '../model/FollowupChamado.class.php';
include '../dao/FollowupChamadoDAO.php';
include '../dao/ChamadoDAO.php';

$followupID = filter_input(INPUT_POST, "spfollowup_id");
$chamadoID = filter_input(INPUT_POST, "spchamado_id");
$tipo = filter_input(INPUT_POST, "spfollowup_tipo");
$usuarioTrans = filter_input(INPUT_POST, "spfollowup_usuario_trans");
$conteudo = filter_input(INPUT_POST, "spfollowup_conteudo");
$usuarioID = $_SESSION['usuarioID'];
$mensagem = array();

$op = filter_input(INPUT_GET, "op");
if($op === 'excluir') {
    $op = 'excluir';
} elseif(!empty($followupID)) {
    $op = 'editar';
} else {
    $op = 'cadastrar';
}

if ($op === 'cadastrar') {
    try {
        if (checaUsuarioAtual($usuarioID, $chamadoID) === false) {
            throw new Exception("Somente o responsável atual pode lançar novos Follow-up!");
        }
        $followupChamado = new FollowupChamado();
        $followupChamado->setTipo($tipo);
        $followupChamado->setConteudo($conteudo);
        $followupChamado->setUsuarioID($usuarioID);
        $followupChamado->setUsuarioTrans($usuarioTrans);
        $followupChamado->setChamadoID($chamadoID);
        $followupChamadoDAO = new FollowupChamadoDAO();
        $followupChamadoDAO->inserir($followupChamado);
        if ($usuarioTrans !== $usuarioID && !empty($usuarioTrans)) {
            trocarUsuarioAtual($usuarioTrans, $chamadoID);
            $mensagem["troca"] = "S";
        }
        $mensagem["sucesso"] = "Incluído com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else if ($op === 'editar') {
    try {
        if (checaUsuarioFollowup($usuarioID, $followupID) === false) {
            throw new Exception("Somente o responsável atual pode editar seus próprios Follow-up!");
        }
        $followupChamado = new FollowupChamado();
        $followupChamado->setChamadoID($chamadoID);
        $followupChamado->setConteudo($conteudo);
        $followupChamado->setUsuarioID($usuarioID);
        $followupChamado->setFollowupID($followupID);
        $followupChamadoDAO = new FollowupChamadoDAO();
        $followupChamadoDAO->atualizar($followupChamado);
        $mensagem["sucesso"] = "Atualizado com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else if ($op === 'excluir') {
    try {
        if (checaUsuarioFollowup($usuarioID, $followupID) === false) {
            throw new Exception("Somente o responsável atual pode excluir seus próprios Follow-up!");
        }
        if (checaChamadoSituacao($chamadoID) === false) {
            throw new Exception("O chamado já está encerrado. Somente pode ser usado para consultas!");
        }
        $followupChamado = new FollowupChamado();
        $followupChamado->setChamadoID($chamadoID);
        $followupChamado->setFollowupID($followupID);
        $followupChamado->setUsuarioID($usuarioID);
        $followupChamadoDAO = new FollowupChamadoDAO();
        $followupChamadoDAO->excluir($followupChamado);
        $mensagem["sucesso"] = "Cancelado com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else {
    $mensagem["erro"] = "Operação Inválida!";
}

function checaChamadoSituacao($cid) {
    $chamadoDAO = new ChamadoDAO();
    return $chamadoDAO->checaChamadoSituacao($cid);
}

function trocarUsuarioAtual($uid, $cid) {
    $chamadoDAO = new ChamadoDAO();
    $chamadoDAO->trocaUsuarioAtual($uid, $cid);
}

function checaUsuarioAtual($uid, $cid) {
    $chamadoDAO = new ChamadoDAO();
    return $chamadoDAO->checaUsuarioAtual($uid, $cid);
}

function checaUsuarioFollowup($uid, $fid) {
    $chamadoDAO = new ChamadoDAO();
    return $chamadoDAO->checaUsuarioFollowup($uid, $fid);
}

echo json_encode($mensagem);
