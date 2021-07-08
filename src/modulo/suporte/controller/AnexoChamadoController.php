<?php

include '../../../seguranca.php';
include '../model/AnexoChamado.class.php';
include '../dao/AnexoChamadoDAO.php';
include '../dao/ChamadoDAO.php';

$anexoID = filter_input(INPUT_POST, "spanexo_id");
$chamadoID = filter_input(INPUT_POST, "chamado_id");
$anexoNome = filter_input(INPUT_POST, "spanexo_nome");
$anexoCaminho = filter_input(INPUT_POST, "spanexo_caminho");
$usuarioID = $_SESSION['usuarioID'];
$mensagem = array();

if (filter_input(INPUT_POST, "op") === 'cadastrar') {
    try {
        if (checaChamadoSituacao($chamadoID) === false) {
            throw new Exception("O chamado já está encerrado. Somente pode ser usado para consultas!");
        }
        $arquivo = $_FILES['file']['name'];
        $upload = new AnexoChamado($arquivo);
        $upload->setChamadoID($chamadoID);
        $upload->setAnexoNome($arquivo);
        $upload->setUsuarioID($usuarioID);
        $upload->fazUpload();
        $anexoChamadoDAO = new AnexoChamadoDAO();
        $anexoChamadoDAO->inserir($upload);
        $mensagem["sucesso"] = "Incluído com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
    }
} else if (filter_input(INPUT_GET, "op") === 'editar') {
    try {
        $upload = new AnexoChamado(null);
        $upload->setAnexoID($anexoID);
        $upload->setAnexoNome($anexoNome);
        $anexoChamadoDAO = new AnexoChamadoDAO();
        $anexoChamadoDAO->atualizar($upload);
        $mensagem["sucesso"] = "Atualizado com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
    }
} else if (filter_input(INPUT_GET, "op") === 'excluir') {
    try {
        if (checaChamadoSituacao($chamadoID) === false) {
            throw new Exception("O chamado já está encerrado. Somente pode ser usado para consultas!");
        }
        $upload = new AnexoChamado(null);
        $upload->setAnexoID($anexoID);
        $upload->setAnexoCaminho($anexoCaminho);
        $anexoChamadoDAO = new AnexoChamadoDAO();
        if ($anexoChamadoDAO->verificaUsuarioAnexo($usuarioID, $anexoID)) {
            $anexoChamadoDAO->excluir($upload);
        } else {
            throw new Exception("Somente é permitido a exclusão de seus próprios anexos!");
        }
        $mensagem["sucesso"] = "Excluído com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
    }
} else {
    $mensagem["erro"] = "Operação Inválida!";
}

function checaChamadoSituacao($cid) {
    $chamadoDAO = new ChamadoDAO();
    return $chamadoDAO->checaChamadoSituacao($cid);
}

echo json_encode($mensagem);
