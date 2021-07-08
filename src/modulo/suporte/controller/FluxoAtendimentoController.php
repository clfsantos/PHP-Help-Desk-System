<?php

include '../../../seguranca.php';
include '../model/FluxoAtendimento.class.php';
include '../dao/FluxoAtendimentoDAO.php';

$usuarioID = filter_input(INPUT_POST, "tecnico");
$clienteID = filter_input(INPUT_POST, "crcliente_id");
$obs = filter_input(INPUT_POST, "fila_obs");
$filaID = filter_input(INPUT_POST, "spchamado_fila_id");

$conexao = new Conexao;
$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$op = filter_input(INPUT_GET, "op");
$mensagem = array();
if ($op === 'prioridade') {
    $sql = 'select * from vw_fluxo_prioridade ORDER BY ultimo_atendimento ASC, spchamado_usuario_prioridade_id ASC';
    $stmt = $conexao->query($sql);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $ctrl = 1;
    echo '<ol class="breadcrumb fluxo">';
    foreach ($rows as $row) {
        if ($ctrl === 1) {
            $active = ' class="active"';
        } else {
            $active = '';
        }
        echo '<li' . $active . '>' . $row['nome'] . ' (' . $row['contar_fluxo'] . ')' . '</li>';
        $ctrl++;
    }
    echo '</ol>';
} elseif ($op === 'cadastrar') {
    try {
        $atendimento = new FluxoAtendimento();
        $atendimento->setUsuarioID($usuarioID);
        $atendimento->setClienteID($clienteID);
        $atendimentoDAO = new FluxoAtendimentoDAO();
        $atendimentoDAO->gravar($atendimento);
        $mensagem["sucesso"] = "Registrado com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
    echo json_encode($mensagem);
} elseif ($op === 'cadastrarfila') {
    try {
        $atendimento = new FluxoAtendimento();
        $atendimento->setFilaID($filaID);
        $atendimento->setClienteID($clienteID);
        $atendimento->setObs($obs);
        $atendimentoDAO = new FluxoAtendimentoDAO();
        $atendimentoDAO->gravarFila($atendimento);
        $mensagem["sucesso"] = "Registrado com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
    echo json_encode($mensagem);
} elseif ($op === 'cadastrarbt') {
    $usuarioID = $_SESSION['usuarioID'];
    $filaID = filter_input(INPUT_POST, "spchamado_fila_id");
    try {
        $atendimento = new FluxoAtendimento();
        $atendimento->setUsuarioID($usuarioID);
        $atendimento->setClienteID($clienteID);
        $atendimentoDAO = new FluxoAtendimentoDAO();
        $atendimentoDAO->gravar($atendimento);
        $atendimentoDAO->marcarAtendido($filaID);
        $mensagem["sucesso"] = "Transferido para o fluxo com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
    echo json_encode($mensagem);
} elseif ($op === 'cancelar') {
    $filaID = filter_input(INPUT_POST, "spchamado_fila_id");
    try {
        $atendimentoDAO = new FluxoAtendimentoDAO();
        $atendimentoDAO->marcarAtendido($filaID);
        $mensagem["sucesso"] = "Atendimento cancelado com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
    echo json_encode($mensagem);
} elseif ($op === 'addretorno') {
    $filaID = filter_input(INPUT_POST, "spchamado_fila_id");
    try {
        $atendimentoDAO = new FluxoAtendimentoDAO();
        $atendimentoDAO->addRetorno($filaID);
        $mensagem["sucesso"] = "Retorno adicionado com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
    echo json_encode($mensagem);
}
