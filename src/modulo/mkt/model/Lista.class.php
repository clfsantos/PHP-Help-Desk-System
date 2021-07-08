<?php

/**
 * Description of Lista
 *
 * @author cesantos
 */
class Lista {
    private $id;
    private $descricao;
    
    function __construct() {
        $this->id = null;
        $this->descricao = null;
    }
    
    function getId() {
        return $this->id;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

}
