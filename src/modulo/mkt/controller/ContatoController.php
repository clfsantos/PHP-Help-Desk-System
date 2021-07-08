<?php

include '../../../seguranca.php';
include '../model/Contato.class.php';
include '../dao/ContatoDAO.php';

$op = filter_input(INPUT_GET, "op");
$ide = filter_input(INPUT_POST, "ide");
$mensagem = array();

if (isset($_POST['lista_id'])) {
    $listas = $_POST['lista_id'];
} else {
    $listas = "";
}

if ($op === 'multiplo') {
    if (isset($_POST['dados'])) {
        $data = json_decode($_POST['dados']);
        $emails = $data[0]->value;
        $cidadeID = $data[1]->value;
        $updateLista = $data[2]->value;
    }
    $emails_filtrados = str_replace(';', ',', $emails);
    $emailsarr = explode(',', $emails_filtrados);
    $contador = 0;
    $contador2 = 0;
    foreach ($emailsarr as $email) {
        $email = trim($email);
        $nome = explode("@", $email);
        try {
            $contato = new Contato();
            $contato->setNome($nome[0]);
            $contato->setEmail($email);
            $contato->setCidadeID($cidadeID);
            $contatoDAO = new ContatoDAO();
            $contatoDAO->cadastrar($contato, $listas, $updateLista);
            $contador2++;
        } catch (Exception $ex) {
            //echo $ex->getMessage() . '\n';
            $contador++;
        }
    }
    $mensagem["sucesso"] = $contador . " e-mail já existiam! " . $contador2 . " novos e-mails foram importados!";
    echo json_encode($mensagem);
    exit;
}

if (isset($_POST['dados'])) {
    $data = json_decode($_POST['dados']);
    $id = $data[0]->value;
    $nome = $data[1]->value;
    $email = $data[2]->value;
    $cidadeID = $data[3]->value;
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
