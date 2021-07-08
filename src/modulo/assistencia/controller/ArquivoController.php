<?php

include '../../../seguranca.php';
include '../model/Arquivo.class.php';
include '../dao/ArquivoDAO.php';

$idArquivo = filter_input(INPUT_POST, "id_arquivo");
$idManutencao = filter_input(INPUT_POST, "assistencia_id");
$nomeArquivo = filter_input(INPUT_POST, "nome_arquivo");
$caminhoFinal = filter_input(INPUT_POST, "caminho_arquivo");
$mensagem = array();

if (filter_input(INPUT_POST, "op") === 'cadastrar') {
    try {
        $arquivo = $_FILES['file']['name'];
        $upload = new Arquivo($arquivo);
        $upload->setIdManutencao($idManutencao);
        $upload->setNomeArquivo($arquivo);
        $upload->fazUpload();
        $arquivoDAO = new ArquivoDAO();
        $arquivoDAO->inserir($upload);
        $mensagem["sucesso"] = "Incluído com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
    }
} else if (filter_input(INPUT_GET, "op") === 'editar') {
    try {
        $upload = new Arquivo(null);
        $upload->setIdArquivo($idArquivo);
        $upload->setNomeArquivo($nomeArquivo);
        $arquivoDAO = new ArquivoDAO();
        $arquivoDAO->atualizar($upload);
        $mensagem["sucesso"] = "Atualizado com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
    }
} else if (filter_input(INPUT_GET, "op") === 'excluir') {
    try {
        $upload = new Arquivo(null);
        $upload->setIdArquivo($idArquivo);
        $upload->setCaminhoFinal($caminhoFinal);
        $arquivoDAO = new ArquivoDAO();
        $arquivoDAO->excluir($upload);
        $mensagem["sucesso"] = "Excluído com Sucesso!";
    } catch (Exception $ex) {
        $mensagem["erro"] = $ex->getMessage();
    }
} else {
    $mensagem["erro"] = "Operação Inválida!";
}

echo json_encode($mensagem);
