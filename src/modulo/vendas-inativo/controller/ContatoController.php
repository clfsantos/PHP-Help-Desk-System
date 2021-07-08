<?php

include '../../seguranca.php';
include '../model/Contato.class.php';
include '../dao/ContatoDAO.php';

$op = filter_input(INPUT_GET, "op");
$ide = filter_input(INPUT_POST, "ide");
$mensagem = array();

if (isset($_POST['dados'])) {
    $data = json_decode($_POST['dados']);
    $id = $data[0]->value;
    $nome = $data[1]->value;
    $email = $data[2]->value;
    $cidadeID = $data[3]->value;
}

if (isset($_POST['lista_id'])) {
    $listas = $_POST['lista_id'];
} else {
    $listas = "";
}

if ($op === 'cadastrar') {
    try {
        $contato = new Contato();
        $contato->setNome($nome);
        $contato->setEmail($email);
        $contato->setCidadeID($cidadeID);
        $contatoDAO = new ContatoDAO();
        $contatoDAO->cadastrar($contato, $listas);
        $mensagem["sucesso"] = "Incluído com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} elseif ($op === 'editar') {
    try {
        $contato = new Contato();
        $contato->setId($id);
        $contato->setNome($nome);
        $contato->setEmail($email);
        $contato->setCidadeID($cidadeID);
        $contatoDAO = new ContatoDAO();
        $contatoDAO->editar($contato, $listas);
        $mensagem["sucesso"] = "Editado com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} elseif ($op === 'excluir') {
    try {
        $contato = new Contato();
        $contato->setId($ide);
        $contatoDAO = new ContatoDAO();
        $contatoDAO->excluir($contato);
        $mensagem["sucesso"] = "Excluído com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
        $mensagem["errocod"] = $ex->getCode();
    }
} else {
    $mensagem["erro"] = "Operação Inválida!";
}

echo json_encode($mensagem);
