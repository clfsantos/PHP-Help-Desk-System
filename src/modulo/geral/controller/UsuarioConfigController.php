<?php

include '../../../seguranca.php';
include '../model/UsuarioConfig.class.php';
include '../dao/UsuarioConfigDAO.php';

$usuario = $_SESSION['usuarioID'];
$senha = filter_input(INPUT_POST, "nova_senha_1");
$senha2 = filter_input(INPUT_POST, "nova_senha_2");
$senha_atual = filter_input(INPUT_POST, "senha_atual");

$op = filter_input(INPUT_GET, "op");
$mensagem = array();

if ($op === 'foto') {

    $storeFolder = '../../../images/perfil/';
    $extensoes = array('jpg', 'png');
    try {
        if (!empty($_FILES)) {
            $tempFile = $_FILES['file']['tmp_name'];
            $targetPath = $storeFolder;
            $fileNameO = $_FILES['file']['name'];
            $ext = explode('.', $fileNameO);
            $extensao = end($ext);
            $str = strtolower($extensao);
            if (array_search($str, $extensoes) === false) {
                throw new Exception("Extensão inválida!");
            }
            $fileName = $usuario . "-" . md5(microtime()) . "_" . md5($fileNameO) . "." . $extensao;
            $targetFile = $targetPath . $fileName;
            $usuarioConfig = new UsuarioConfig();
            $usuarioConfig->setIdUsuario($usuario);
            $usuarioConfig->setAvatar($fileName);
            $usuarioConfigDAO = new UsuarioConfigDAO();
            $usuarioConfigDAO->mudarAvatar($usuarioConfig);
            $mensagem["sucesso"] = "Foto alterada com Sucesso!";
            move_uploaded_file($tempFile, $targetFile);
        } else {
            throw new Exception("Falta o Arquivo");
        }
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
    }
} else {
    try {
        $usuarioConfig = new UsuarioConfig();
        $usuarioConfig->setIdUsuario($usuario);
        $usuarioConfig->setSenha($senha);
        $usuarioConfigDAO = new UsuarioConfigDAO();

        if ($senha !== $senha2) {
            throw new Exception("Senhas não conferem!");
        }
        if ($usuarioConfigDAO->checarSenha($usuarioConfig, $senha_atual) === false) {
            throw new Exception("Senha atual não confere!");
        }

        $usuarioConfigDAO->mudarSenha($usuarioConfig);
        $mensagem["sucesso"] = "Senha alterada com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
    }
}

echo json_encode($mensagem);
