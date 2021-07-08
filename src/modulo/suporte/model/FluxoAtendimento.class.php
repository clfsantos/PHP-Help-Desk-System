<?php

class FluxoAtendimento {
    private $usuarioID;
    private $clienteID;
    private $obs;
    private $filaID;
    
    function __construct() {
        $this->usuarioID = null;
        $this->clienteID = null;
        $this->obs = null;
        $this->filaID = null;
    }
    
    function getUsuarioID() {
        return $this->usuarioID;
    }

    function getClienteID() {
        return $this->clienteID;
    }
    
    function getObs() {
        return $this->obs;
    }
    
    function getFilaID() {
        return $this->filaID;
    }

    function setUsuarioID($usuarioID) {
        if (!preg_match("/^\d+$/", $usuarioID)) {
            throw new Exception('ID do técnico inválido!', 101);
        }
        $this->usuarioID = $usuarioID;
    }

    function setClienteID($clienteID) {
        if (!preg_match("/^\d+$/", $clienteID)) {
            throw new Exception('ID do cliente inválido!', 102);
        }
        $this->clienteID = $clienteID;
    }
    
    function setObs($obs) {
        $this->obs = $obs;
    }
    
    function setFilaID($filaID) {
        $this->filaID = $filaID;
    }

}