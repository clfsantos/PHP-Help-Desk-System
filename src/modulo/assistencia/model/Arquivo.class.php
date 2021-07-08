<?php

/**
 * Description of Arquivo
 *
 * @author cesantos
 */
class Arquivo {
    
    private $idArquivo;
    private $idManutencao;
    private $nomeArquivo;
    private $caminhoFinal;
    private $pasta;
    private $arquivo;
    private $tamanho;
    private $extensoes;
    private $renomeia;

    function __construct($arquivo) {
        $this->pasta = '../arquivos/';
        $this->arquivo = $arquivo;
        $this->tamanho = 1024 * 1024 * 8;
        $this->extensoes = array('jpg', 'png', 'gif', 'txt', 'zip', 'rar', 'pdf');
        $this->renomeia = true;
    }
    
    public function getIdArquivo() {
        return $this->idArquivo;
    }
    
    public function getIdManutencao() {
        return $this->idManutencao;
    }

    public function getNomeArquivo() {
        return $this->nomeArquivo;
    }

    public function getCaminhoFinal() {
        return $this->caminhoFinal;
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
    
    public function setIdArquivo($idArquivo) {
        $this->idArquivo = $idArquivo;
    }
    
    public function setIdManutencao($idManutencao) {
        $this->idManutencao = $idManutencao;
    }

    public function setNomeArquivo($nomeArquivo) {
        $this->nomeArquivo = $nomeArquivo;
    }

    public function setCaminhoFinal($caminhoFinal) {
        $this->caminhoFinal = $caminhoFinal;
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
            $this->arquivo = time()."_".$this->arquivo;
        }
        if (move_uploaded_file($_FILES['file']['tmp_name'], $this->pasta . $this->arquivo)) {
            $this->caminhoFinal = $this->pasta . $this->arquivo;
        } else {
            throw new Exception("Erro no Upload!");
        }
    }
    
}
