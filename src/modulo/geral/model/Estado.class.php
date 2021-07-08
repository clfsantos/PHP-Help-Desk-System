<?php
/**
 * Description of Estado
 *
 * @author cesantos
 */
class Estado {
    private $id;
    private $nome;
    private $sigla;
    
    function __construct() {
        $this->id = null;
        $this->nome = null;
        $this->sigla = null;
    }
    
    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getSigla() {
        return $this->sigla;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $nome = trim($nome);
        if (strlen($nome) < 2) {
            throw new Exception('O nome do estado deve haver ao menos 2 caracteres!', 102);
        } elseif (strlen($nome) > 60) {
            throw new Exception('O nome do estado deve haver menos de 60 caracteres!', 103);
        }
        $this->nome = $nome;
    }

    function setSigla($sigla) {
        $sigla = trim($sigla);
        if (strlen($sigla) !== 2) {
            throw new Exception('A sigla do estado deve ter 2 caracteres!', 101);
        }
        $this->sigla = $sigla;
    }

}
