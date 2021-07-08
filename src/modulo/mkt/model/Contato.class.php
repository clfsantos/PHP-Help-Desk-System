<?php

class Contato {

    private $id;
    private $nome;
    private $email;
    private $cidadeID;

    function __construct() {
        $this->id = null;
        $this->nome = null;
        $this->email = null;
        $this->cidadeID = null;
    }

    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getEmail() {
        return $this->email;
    }

    function getCidadeID() {
        return $this->cidadeID;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $nome = trim($nome);
        if(empty($nome)) {
            throw new Exception("O nome não pode estar em branco!", 102);
        } else {
            $this->nome = $nome;
        }
    }

    function setEmail($email) {
        if (!preg_match("/^[_A-Za-z0-9-\\+]+(\\.[_A-Za-z0-9-]+)*@[A-Za-z0-9-]+(\\.[A-Za-z0-9]+)*(\\.[A-Za-z]{2,})$/", $email)) {
            throw new Exception("O email é inválido!", 103);
        } else {
            $this->email = $email;
        }
    }

    function setCidadeID($cidadeID) {
        if (!preg_match("/^\d+$/", $cidadeID)) {
            throw new Exception("O ID da cidade é inválido!", 104);
        } else {
            $this->cidadeID = $cidadeID;
        }
    }

}
