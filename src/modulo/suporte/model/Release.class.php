<?php

class Release {

    private $spchamado_release_id;
    private $spchamado_produto_id;
    private $spchamado_release_num;
    private $spchamado_release_desc;
    private $spchamado_release_dt;

    function __construct() {
        $this->spchamado_release_id = null;
        $this->spchamado_produto_id = null;
        $this->spchamado_release_num = null;
        $this->spchamado_release_desc = null;
        $this->spchamado_release_dt = null;
    }

    function getSpchamado_release_id() {
        return $this->spchamado_release_id;
    }

    function getSpchamado_produto_id() {
        return $this->spchamado_produto_id;
    }

    function getSpchamado_release_num() {
        return $this->spchamado_release_num;
    }

    function getSpchamado_release_desc() {
        return $this->spchamado_release_desc;
    }

    function getSpchamado_release_dt() {
        return $this->spchamado_release_dt;
    }

    function setSpchamado_release_id($spchamado_release_id) {
        $this->spchamado_release_id = $spchamado_release_id;
    }

    function setSpchamado_produto_id($spchamado_produto_id) {
        if (!preg_match("/^\d+$/", $spchamado_produto_id)) {
            throw new Exception('ID do produto inválido! Selecione um produto', 102);
        }
        $this->spchamado_produto_id = $spchamado_produto_id;
    }

    function setSpchamado_release_num($spchamado_release_num) {
        $spchamado_release_num = trim($spchamado_release_num);
        if (empty($spchamado_release_num)) {
            throw new Exception('A versão da release deve ser preenchida!', 103);
        }
        $this->spchamado_release_num = $spchamado_release_num;
    }

    function setSpchamado_release_desc($spchamado_release_desc) {
        $spchamado_release_desc = trim($spchamado_release_desc);
        if (empty($spchamado_release_desc)) {
            throw new Exception('As alterações da release deve ser preenchida!', 104);
        }
        $this->spchamado_release_desc = $spchamado_release_desc;
    }

    function setSpchamado_release_dt($spchamado_release_dt) {
        if (!$this->validarData($spchamado_release_dt)) {
            throw new Exception('A data informada é inválida!', 105);
        } else {
            $this->spchamado_release_dt = $this->formataData($spchamado_release_dt);
        }
    }

    private function formataData($data) {
        $data = trim($data);
        $data = str_replace("/", "-", $data);
        date_default_timezone_set('America/Sao_Paulo');
        $newDate = date("Y-m-d", strtotime($data));
        return $newDate;
    }

    function validarData($data, $format = 'd/m/Y') {
        $dateTime = new DateTime();
        $d = $dateTime->createFromFormat($format, $data);
        if ($d && $d->format($format) == $data) {
            return true;
        } else {
            return false;
        }
    }

}
