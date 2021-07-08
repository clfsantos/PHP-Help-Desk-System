<?php

class Cidade {
    
    private $cidadeID;
    private $nome;
    private $estadoID;
    
    function __construct() {
        $this->cidadeID = null;
        $this->nome = null;
        $this->estadoID = null;
    }
    
    function getCidadeID() {
        return $this->cidadeID;
    }

    function getNome() {
        return $this->nome;
    }

    function getEstadoID() {
        return $this->estadoID;
    }

    function setCidadeID($cidadeID) {
        $this->cidadeID = $cidadeID;
        return $this;
    }

    function setNome($nome) {
        $nome = trim($nome);
        if (strlen($nome) < 2) {
            throw new Exception('O nome da cidade deve haver ao menos 2 caracteres!', 101);
        } elseif (strlen($nome) > 60) {
            throw new Exception('O nome da cidade deve haver menos de 60 caracteres!', 102);
        }
        $this->nome = $nome;
    }

    function setEstadoID($estadoID) {
        if (!preg_match("/^\d+$/", $estadoID)) {
            throw new Exception('Código do estado inválido!', 103);
        }
        $this->estadoID = $estadoID;
    }
    
}
