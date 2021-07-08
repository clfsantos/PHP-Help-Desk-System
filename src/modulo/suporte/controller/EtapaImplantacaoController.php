<?php

include '../../../seguranca.php';
//include '../model/TarefaChamado.class.php';
include '../dao/ImplantacaoChamadoDAO.php';

$op = filter_input(INPUT_GET, "op");
$chamadoID = filter_input(INPUT_POST, "spchamado_id");
$etapaID = filter_input(INPUT_POST, "etapa_id");
$etapaOBS = filter_input(INPUT_POST, "etapa_obs");
$etapaIDR = filter_input(INPUT_POST, "etapa_id_r");
$etapaOBSR = filter_input(INPUT_POST, "etapa_obs_r");
$usuarioID = $_SESSION['usuarioID'];

$mensagem = array();

//$mensagem["erro"] = $chamadoID . $etapaID . $etapaOBS . $usuarioID;
//
//echo json_encode($mensagem);
//exit;

if ($op === 'concluir') {
    try {
        $implantacaoChamadoDAO = new ImplantacaoChamadoDAO();
        if (in_array($usuarioID, $implantacaoChamadoDAO->usuarioEtapaAndamento($etapaID))) {
        //if ($implantacaoChamadoDAO->usuarioEtapaAndamento($etapaID) === $usuarioID) {
            $implantacaoChamadoDAO->concluirEtapa($etapaID, $etapaOBS);
            $mensagem["sucesso"] = "Concluída com Sucesso!";
        } else {
            $mensagem["erro"] = "Somente o responsável pela etapa pode concluir a mesma!";
        }
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} elseif ($op === 'recusar') {
    try {
        $implantacaoChamadoDAO = new ImplantacaoChamadoDAO();
        if (in_array($usuarioID, $implantacaoChamadoDAO->usuarioProximaEtapa($etapaIDR)) || empty($implantacaoChamadoDAO->usuarioProximaEtapa($etapaIDR))) {
            $implantacaoChamadoDAO->recusarEtapa($etapaIDR, $etapaOBSR);
            $mensagem["sucesso"] = "Recusado com Sucesso!";
        } else {
            $mensagem["erro"] = "Somente o responsável pela próxima etapa pode recusar!";
        }
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else if ($op === 'aprovar') {
    try {
        $implantacaoChamadoDAO = new ImplantacaoChamadoDAO();
        if (in_array($usuarioID, $implantacaoChamadoDAO->usuarioProximaEtapa($etapaID)) || empty(in_array($usuarioID, $implantacaoChamadoDAO->usuarioProximaEtapa($etapaID)))) {
            $implantacaoChamadoDAO->aprovarEtapa($etapaID);
            $mensagem["sucesso"] = "Aprovada com Sucesso!";
        } else {
            $mensagem["erro"] = "Somente o responsável pela próxima etapa pode aprovar!";
        }
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} elseif ($op === 'salvar') {
    try {
        $implantacaoChamadoDAO = new ImplantacaoChamadoDAO();
        if (in_array($usuarioID, $implantacaoChamadoDAO->usuarioEtapaAndamento($etapaID))) {
        //if ($implantacaoChamadoDAO->usuarioEtapaAndamento($etapaID) === $usuarioID) {
            $implantacaoChamadoDAO->salvarEtapa($etapaID, $etapaOBS);
            $mensagem["sucesso"] = "Salvo com Sucesso!";
        } else {
            $mensagem["erro"] = "Somente o responsável pela etapa pode salvar a mesma!";
        }
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else {
    $mensagem["erro"] = "Operação Inválida!";
}

echo json_encode($mensagem);
