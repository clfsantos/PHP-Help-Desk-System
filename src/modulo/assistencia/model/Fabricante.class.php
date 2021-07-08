<?php
/**
 * Description of Fabricante
 *
 * @author cesantos
 */
class Fabricante {
    
    private $codigo;
    private $nome;
    
    public function __construct() {
        $this->codigo = 0;
        $this->nome = "";
    }
    
    public function getCodigo() {
        return $this->codigo;
    }
    
    public function getNome() {
        return $this->nome;
    }
    
    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }
    
    public function setNome($nome) {
        $nome = trim($nome);
        if (strlen($nome) < 2) {
            throw new Exception('O nome do fabricante deve haver ao menos 2 caracteres!', 101);
        } elseif (strlen($nome) > 60) {
            throw new Exception('O nome do fabricante deve haver menos de 60 caracteres!', 102);
        }
        $this->nome = $nome;
    }
    
}
