<?php

/**
 * Description of Modelo
 *
 * @author cesantos
 */
class Modelo {

    private $codigo;
    private $descricao;
    private $codigoFabricante;
    private $idCategoria;

    public function __construct() {
        $this->codigo = null;
        $this->descricao = null;
        $this->codigoFabricante = null;
        $this->idCategoria = null;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getCodigoFabricante() {
        return $this->codigoFabricante;
    }

    public function getIdCategoria() {
        return $this->idCategoria;
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    public function setDescricao($descricao) {
        $descricao = trim($descricao);
        if (strlen($descricao) < 2) {
            throw new Exception('A descrição do modelo deve haver ao menos 2 caracteres!', 101);
        } elseif (strlen($descricao) > 60) {
            throw new Exception('A descrição do modelo deve haver menos de 60 caracteres!', 102);
        }
        $this->descricao = $descricao;
    }

    public function setCodigoFabricante($codigoFabricante) {
        if (!preg_match("/^\d+$/", $codigoFabricante)) {
            throw new Exception('Código do fabricante inválido!', 103);
        }
        $this->codigoFabricante = $codigoFabricante;
    }

    public function setIdCategoria($idCategoria) {
        if (!preg_match("/^\d+$/", $idCategoria)) {
            throw new Exception('Código da categoria inválido!', 104);
        }
        $this->idCategoria = $idCategoria;
    }

}
