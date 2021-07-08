<?php

/**
 * Description of Recado
 *
 * @author cesantos
 */
class Recado {
    
    private $ID;
    private $empresa;
    private $contato;
    private $departamento;
    private $recadoOBS;
    private $usuarioID;
    
    function __construct() {
        $this->ID = null;
        $this->empresa = null;
        $this->contato = null;
        $this->departamento = null;
        $this->recadoOBS = null;
        $this->usuarioID = null;
    }
    
    function getID() {
        return $this->ID;
    }

    function getEmpresa() {
        return $this->empresa;
    }

    function getContato() {
        return $this->contato;
    }

    function getDepartamento() {
        return $this->departamento;
    }

    function getRecadoOBS() {
        return $this->recadoOBS;
    }
    
    function getUsuarioID() {
        return $this->usuarioID;
    }

    function setID($ID) {
        $this->ID = $ID;
    }

    function setEmpresa($empresa) {
        if (empty(trim($empresa))) {
            throw new Exception('A empresa deve ser preenchida!', 101);
        }
        $this->empresa = $empresa;
    }

    function setContato($contato) {
        if (empty(trim($contato))) {
            throw new Exception('O contato deve ser preenchido!', 102);
        }
        $this->contato = $contato;
    }

    function setDepartamento($departamento) {
        if (empty(trim($departamento))) {
            throw new Exception('O Departamento deve ser preenchido!', 103);
        }
        $this->departamento = $departamento;
    }

    function setRecadoOBS($recadoOBS) {
        if (empty(trim($recadoOBS))) {
            throw new Exception('O recado deve ser preenchido!', 104);
        }
        $this->recadoOBS = $recadoOBS;
    }
    
    function setUsuarioID($usuarioID) {
        $this->usuarioID = $usuarioID;
    }

}
