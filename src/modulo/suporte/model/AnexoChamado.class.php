<?php

/**
 * Description of AnexoChamado
 *
 * @author cesantos
 */
class AnexoChamado {

    private $anexoID;
    private $chamadoID;
    private $anexoNome;
    private $anexoCaminho;
    private $pasta;
    private $arquivo;
    private $tamanho;
    private $extensoes;
    private $renomeia;
    private $usuarioID;

    function __construct($arquivo) {
        $this->pasta = '../arquivos/';
        $this->arquivo = $arquivo;
        $this->tamanho = 1024 * 1024 * 100;
        $this->extensoes = array('jpg', 'jpeg', 'png', 'gif', 'txt', 'zip', 'rar', 'pdf', 'backup');
        $this->renomeia = true;
    }

    function getAnexoID() {
        return $this->anexoID;
    }

    function getChamadoID() {
        return $this->chamadoID;
    }

    function getAnexoNome() {
        return $this->anexoNome;
    }

    function getAnexoCaminho() {
        return $this->anexoCaminho;
    }

    public function getPasta() {
        return $this->pasta;
    }

    public function getArquivo() {
        return $this->arquivo;
    }

    public function getTamanho() {
        return $this->tamanho;
    }

    public function getExtensoes() {
        return $this->extensoes;
    }

    public function getRenomeia() {
        return $this->renomeia;
    }

    function getUsuarioID() {
        return $this->usuarioID;
    }

    function setAnexoID($anexoID) {
        $this->anexoID = $anexoID;
    }

    function setChamadoID($chamadoID) {
        $this->chamadoID = $chamadoID;
    }

    function setAnexoNome($anexoNome) {
        $this->anexoNome = $anexoNome;
    }

    function setAnexoCaminho($anexoCaminho) {
        $this->anexoCaminho = $anexoCaminho;
    }

    public function setPasta($pasta) {
        $this->pasta = $pasta;
    }

    public function setArquivo($arquivo) {
        $this->arquivo = $arquivo;
    }

    public function setTamanho($tamanho) {
        $this->tamanho = $tamanho;
    }

    public function setExtensoes($extensoes) {
        $this->extensoes = $extensoes;
    }

    public function setRenomeia($renomeia) {
        $this->renomeia = $renomeia;
    }

    function setUsuarioID($usuarioID) {
        $this->usuarioID = $usuarioID;
    }

    public function fazUpload() {
        if ($this->arquivo === "") {
            throw new Exception("Selecione algum arquivo para ser enviado!");
        }
        $ext = explode('.', $this->arquivo);
        $extensao = end($ext);
        $str = strtolower($extensao);
        if (array_search($str, $this->extensoes) === false) {
            throw new Exception("Extensão inválida!");
        }
        if ($this->tamanho < $_FILES['file']['size']) {
            throw new Exception("O tamanho do arquivo é inválido!");
        }
        if ($this->renomeia === true) {
            $this->arquivo = time() . "_" . $this->arquivo;
        }
        if (move_uploaded_file($_FILES['file']['tmp_name'], $this->pasta . $this->arquivo)) {
            $this->caminhoFinal = $this->pasta . $this->arquivo;
        } else {
            throw new Exception("Erro no Upload!");
        }
    }

}
