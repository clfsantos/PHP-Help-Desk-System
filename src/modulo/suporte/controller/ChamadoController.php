<?php

include '../../../seguranca.php';
include '../model/Chamado.class.php';
include '../dao/ChamadoDAO.php';

$chamadoID = filter_input(INPUT_POST, "spchamado_id");
$clienteID = filter_input(INPUT_POST, "crcliente_id");
$dtUltimaPesquisa = filter_input(INPUT_POST, "dt_ultima_pesquisa");
$contato = filter_input(INPUT_POST, "spchamado_contato");
$financeiro = filter_input(INPUT_POST, "spchamado_financeiro");
$osRel = filter_input(INPUT_POST, "spchamado_osrel");
$origemID = filter_input(INPUT_POST, "spchamado_origem_id");
$classID = filter_input(INPUT_POST, "spchamado_class_id");
$produtoID = filter_input(INPUT_POST, "spchamado_produto_id");
$titulo = filter_input(INPUT_POST, "spchamado_titulo");
$ocorrencia = filter_input(INPUT_POST, "spchamado_ocorrencia");
$parecerFinal = filter_input(INPUT_POST, "spchamado_resolver");
$reseaseID = filter_input(INPUT_POST, "spchamado_release_id");
if (filter_input(INPUT_POST, "spchamado_aberto")) {
    $situacao = 0;
	$status = 2;
} else {
    $situacao = 1;
	$status = 1;
}
$prioridadeSLAID = filter_input(INPUT_POST, "spchamado_sla_prioridade_id");
$dtVencimentoSLA = filter_input(INPUT_POST, "spchamado_sla_data_vto_nft");
$grupoID = filter_input(INPUT_POST, "spchamado_grupo_id");
$subGrupoID = filter_input(INPUT_POST, "spchamado_subgrupo_id");
$clienteMail = filter_input(INPUT_POST, "crcliente_email");
$usuarioID = $_SESSION['usuarioID'];
$mensagem = array();

if (filter_input(INPUT_GET, "op") === 'cadastrar') {
    try {
        $chamado = new Chamado();
        $chamado->setClienteID($clienteID);
        $chamado->setDtUltimaPesquisa($dtUltimaPesquisa);
        $chamado->setContato($contato);
        $chamado->setFinanceiro($financeiro);
        $chamado->setOsRel($osRel);
        $chamado->setOrigemID($origemID);
        $chamado->setClassID($classID);
        $chamado->setProdutoID($produtoID);
        $chamado->setTitulo($titulo);
        $chamado->setOcorrencia($ocorrencia);
        $chamado->setParecerFinal($parecerFinal);
        $chamado->setReleaseID($reseaseID);
        $chamado->setSituacao($situacao);
		$chamado->setStatus($status);
        $chamado->setCriador($usuarioID);
        $chamado->setResponsavelAtual($usuarioID);
        $chamado->setFinalizadoPor($usuarioID);
        $chamado->setPrioridadeSLAID($prioridadeSLAID);
        $chamado->setDtVencimentoSLA($dtVencimentoSLA);
        $chamado->setGrupoID($grupoID);
        $chamado->setSubGrupoID($subGrupoID);
        $chamado->setClienteMail($clienteMail);
        $fechado = $chamado->verificaFechamento();
        $chamadoDAO = new ChamadoDAO();
        $lastID = $chamadoDAO->inserir($chamado);
        //$teste_temp_pesquisa = $chamadoDAO->enviarPesquisa($chamado, $lastID, $fechado);
        $mensagem["sucesso"] = "Incluído com Sucesso!";
        $mensagem["lastid"] = $lastID;
        //$mensagem["pesquisa"] = $teste_temp_pesquisa;
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else if (filter_input(INPUT_GET, "op") === 'editar') {
    try {
        $chamado = new Chamado();
        $chamadoDAO = new ChamadoDAO();
        if (!$chamadoDAO->checaProdutoGrupo($produtoID, $grupoID)) {
            throw new Exception('O ID do grupo é inválido!');
        }
        $chamado->setChamadoID($chamadoID);
        $chamado->setClienteID($clienteID);
        $chamado->setDtUltimaPesquisa($dtUltimaPesquisa);
        $chamado->setContato($contato);
        $chamado->setFinanceiro($financeiro);
        $chamado->setOsRel($osRel);
        $chamado->setOrigemID($origemID);
        $chamado->setClassID($classID);
        $chamado->setProdutoID($produtoID);
        $chamado->setTitulo($titulo);
        $chamado->setOcorrencia($ocorrencia);
        $chamado->setParecerFinal($parecerFinal);
        $chamado->setReleaseID($reseaseID);
        $chamado->setSituacao($situacao);
		$chamado->setStatus($status);
        $chamado->setCriador($usuarioID);
        $chamado->setResponsavelAtual($usuarioID);
        $chamado->setFinalizadoPor($usuarioID);
        $chamado->setGrupoID($grupoID);
        $chamado->setSubGrupoID($subGrupoID);
        $chamado->setClienteMail($clienteMail);
        $ok = $chamado->verificaFechamento();
        if ($ok) {
            if ($chamadoDAO->checaTarefas($chamadoID)) {
                throw new Exception("Existem tarefas não concluidas relacionadas com esse chamado!");
            }
        }
        $chamadoDAO->atualizar($chamado);
        //$teste_temp_pesquisa = $chamadoDAO->enviarPesquisa($chamado, $chamadoID, $ok);
        $mensagem["sucesso"] = "Atualizado com Sucesso!";
        //$mensagem["pesquisa"] = $teste_temp_pesquisa;
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else if (filter_input(INPUT_GET, "op") === 'cancelar') {
    try {
        $chamado = new Chamado();
        $chamado->setChamadoID($chamadoID);
        $chamadoDAO = new ChamadoDAO();
        if (!$chamadoDAO->checaUsuarioAtual($usuarioID, $chamadoID)) {
            throw new Exception("Somente o responsável atual do chamado pode cancelar o mesmo!");
        }
        if ($chamadoDAO->checaTarefas($chamadoID)) {
            throw new Exception("Existem tarefas não concluidas relacionadas com esse chamado!");
        }
        $chamadoDAO->cancelar($chamado);
        $mensagem["sucesso"] = "Cancelado com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else if (filter_input(INPUT_GET, "op") === 'assumir') {
    try {
        $chamadoDAO = new ChamadoDAO();
        $chamadoDAO->trocaUsuarioAtual($usuarioID, $chamadoID);
        $mensagem["sucesso"] = "Atualizado com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else {
    $mensagem["erro"] = "Operação Inválida!";
}

echo json_encode($mensagem);
