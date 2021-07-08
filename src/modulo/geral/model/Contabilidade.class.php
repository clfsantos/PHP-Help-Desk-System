<?php

class Contabilidade {
    
    private $contabilidadeID;
    private $cnpj;
	private $nome;
	private $contato;
	private $email;
	private $telefone;
	private $obs;
    
    function __construct() {
        $this->contabilidadeID = null;
        $this->cnpj = null;
		$this->nome = null;
		$this->contato = null;
		$this->email = null;
		$this->telefone = null;
		$this->obs = null;
    }
    
    function getContabilidadeID() {
        return $this->contabilidadeID;
    }

    function getCnpj() {
        return $this->cnpj;
    }
	
	function getNome() {
        return $this->nome;
    }
	
	function getContato() {
        return $this->contato;
    }
	
	function getEmail() {
        return $this->email;
    }
	
	function getTelefone() {
        return $this->telefone;
    }
	
	function getObs() {
        return $this->obs;
    }

    function setContabilidadeID($contabilidadeID) {
        $this->contabilidadeID = $contabilidadeID;
    }
	
	function setCnpj($cnpj) {
		$cnpj = trim($cnpj);
		if (strlen($cnpj) <> 11 && strlen($cnpj) <> 14) {
            throw new Exception('CNPJ ou CPF inválido!' . strlen($cnpj), 101);
        }
        $this->cnpj = $cnpj;
    }
	
	function setNome($nome) {
        $nome = trim($nome);
        if (strlen($nome) < 2) {
            throw new Exception('O nome da contabilidade deve haver ao menos 2 caracteres!', 102);
        } elseif (strlen($nome) > 60) {
            throw new Exception('O nome da contabilidade deve haver menos de 60 caracteres!', 103);
        }
        $this->nome = $nome;
    }
	
	function setContato($contato) {
        $this->contato = $contato;
    }
	
	function setEmail($email) {
		if(!empty(trim($email))) {
			if (!preg_match("/^[_A-Za-z0-9-\\+]+(\\.[_A-Za-z0-9-]+)*@[A-Za-z0-9-]+(\\.[A-Za-z0-9]+)*(\\.[A-Za-z]{2,})$/", $email)) {
				throw new Exception("O email é inválido!", 104);
			}
		}
        $this->email = $email;
    }
	
	function setTelefone($telefone) {
		$telefone = trim($telefone);
        $telefone = str_replace("(", "", $telefone);
        $telefone = str_replace(")", "", $telefone);
        $telefone = str_replace("-", "", $telefone);
        $telefone = str_replace(".", "", $telefone);
        $telefone = str_replace(" ", "", $telefone);
        $this->telefone = $telefone;
    }
	
	function setObs($obs) {
        $this->obs = $obs;
    }
    
}
