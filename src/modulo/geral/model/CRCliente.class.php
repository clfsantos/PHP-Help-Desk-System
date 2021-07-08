<?php

/**
 * Description of CRCliente
 *
 * @author cesantos
 */
class CRCliente {
    
    private $crclienteId;
    private $crclienteBloqueado;
	private $crclienteCelular;
	private $crclienteEmailRH;
    private $crclienteOBS;
	private $contabilidade_id;
    
    function __construct() {
        $this->crclienteId = null;
        $this->crclienteBloqueado = null;
        $this->crclienteCelular = null;
		$this->crclienteEmailRH = null;
		$this->crclienteOBS = null;
		$this->contabilidade_id = null;
    }
    
    function getCrclienteId() {
        return $this->crclienteId;
    }

    function getCrclienteBloqueado() {
        return $this->crclienteBloqueado;
    }
	function getCrClienteCelular() {
        return $this->crclienteCelular;
    }
	
	function getCrClienteEmailRH() {
        return $this->crclienteEmailRH;
    }
    
    function getCrclienteOBS() {
        return $this->crclienteOBS;
    }
	
	function getContabilidadeId() {
        return $this->contabilidade_id;
    }

    function setCrclienteId($crclienteId) {
        $this->crclienteId = $crclienteId;
    }

    function setCrClienteCelular($crclienteCelular) {
		$crclienteCelular = trim($crclienteCelular);
        $crclienteCelular = str_replace("(", "", $crclienteCelular);
        $crclienteCelular = str_replace(")", "", $crclienteCelular);
        $crclienteCelular = str_replace("-", "", $crclienteCelular);
        $crclienteCelular = str_replace(".", "", $crclienteCelular);
        $crclienteCelular = str_replace(" ", "", $crclienteCelular);
        $this->crclienteCelular = $crclienteCelular;
    }
	
	function setCrClienteEmailRH($crclienteEmailRH) {
		if(!empty(trim($crclienteEmailRH))) {
			if (!preg_match("/^[_A-Za-z0-9-\\+]+(\\.[_A-Za-z0-9-]+)*@[A-Za-z0-9-]+(\\.[A-Za-z0-9]+)*(\\.[A-Za-z]{2,})$/", $crclienteEmailRH)) {
				throw new Exception("O email do RH é inválido!", 102);
			}
		}
        $this->crclienteEmailRH = $crclienteEmailRH;
    }
	
	function setCrclienteBloqueado($crclienteBloqueado) {
        $this->crclienteBloqueado = $crclienteBloqueado;
    }
    
    function setCrclienteOBS($crclienteOBS) {
        $this->crclienteOBS = $crclienteOBS;
    }
	
	function setContabilidadeId($contabilidade_id) {
		if (!preg_match("/^\d+$/", $contabilidade_id)) {
            $contabilidade_id = null;
        }
        $this->contabilidade_id = $contabilidade_id;
    }
    
}