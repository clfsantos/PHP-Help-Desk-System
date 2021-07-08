<?php

/**
 * Description of Usuario
 *
 * @author cesantos
 */
class UsuarioConfig {
    
    private $idUsuario;
    private $idPerfil;
    private $nome;
    private $telefone;
    private $email;
    private $login;
    private $senha;
    private $endereco;
    private $idCidade;
    private $avatar;
    
    public function __construct() {
        
    }
    
    public function getIdUsuario() {
        return $this->idUsuario;
    }

    public function getIdPerfil() {
        return $this->idPerfil;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getLogin() {
        return $this->login;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function getEndereco() {
        return $this->endereco;
    }

    public function getIdCidade() {
        return $this->idCidade;
    }
    
    function getAvatar() {
        return $this->avatar;
    }

    public function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    public function setIdPerfil($idPerfil) {
        $this->idPerfil = $idPerfil;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }

    public function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    public function setIdCidade($idCidade) {
        $this->idCidade = $idCidade;
    }
    
    function setAvatar($avatar) {
        $this->avatar = $avatar;
    }
    
}
