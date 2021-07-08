<?php

/**
 * Description of Equipamento
 *
 * @author cesantos
 */
class Equipamento {

    private $codigo;
    private $nrSerie;
    private $codigoEmpresa;
    private $idModelo;
    private $testeOK;
    private $inativo;

    function __construct() {
        $this->codigo = null;
        $this->nrSerie = null;
        $this->codigoEmpresa = null;
        $this->idModelo = null;
        $this->testeOK = null;
        $this->inativo = null;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function getNrSerie() {
        return $this->nrSerie;
    }

    public function getCodigoEmpresa() {
        return $this->codigoEmpresa;
    }

    public function getIdModelo() {
        return $this->idModelo;
    }
    
    public function getTesteOK() {
        return $this->testeOK;
    }

    public function getInativo() {
        return $this->inativo;
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    public function setNrSerie($nrSerie) {
        $nrSerie = trim($nrSerie);
        if (strlen($nrSerie) < 2) {
            throw new Exception('O NRS deve ter ao menos 2 caracteres!', 101);
        } elseif (strlen($nrSerie) > 17) {
            throw new Exception('O NRS não deve ter mais de 17 caracteres!', 102);
        } elseif (!preg_match("/^[A-Za-z0-9]+$/", $nrSerie)) {
            throw new Exception('No NRS só pode conter letras do alfabeto e/ou números! Verifique a existência de caracteres especiais ou espaços em branco.', 103);
        }
        $this->nrSerie = $nrSerie;
    }

    public function setCodigoEmpresa($codigoEmpresa) {
        if (!preg_match("/^\d+$/", $codigoEmpresa)) {
            throw new Exception('ID do cliente inválido!', 104);
        }
        $this->codigoEmpresa = $codigoEmpresa;
    }

    public function setIdModelo($idModelo) {
        if (!preg_match("/^\d+$/", $idModelo)) {
            throw new Exception('ID do modelo inválido!', 105);
        }
        $this->idModelo = $idModelo;
    }
    
    public function setTesteOK($testeOK) {
        $this->testeOK = $testeOK;
    }

    public function setInativo($inativo) {
        $this->inativo = $inativo;
    }

}
