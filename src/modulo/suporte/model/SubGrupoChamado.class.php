<?php

class SubGrupoChamado {
    private $spchamado_subgrupo_id;
    private $spchamado_subgrupo_desc;
    
    function __construct() {
        $this->spchamado_subgrupo_id = null;
        $this->spchamado_subgrupo_desc = null;
    }
    
    function getSpchamado_subgrupo_id() {
        return $this->spchamado_subgrupo_id;
    }

    function getSpchamado_subgrupo_desc() {
        return $this->spchamado_subgrupo_desc;
    }

    function setSpchamado_subgrupo_id($spchamado_subgrupo_id) {
        $this->spchamado_subgrupo_id = $spchamado_subgrupo_id;
    }

    function setSpchamado_subgrupo_desc($spchamado_subgrupo_desc) {
        $spchamado_subgrupo_desc = trim($spchamado_subgrupo_desc);
        if(empty($spchamado_subgrupo_desc)) {
            throw new Exception("A descrição do sub-grupo não pode estar em branco", 102);
        }
        $this->spchamado_subgrupo_desc = $spchamado_subgrupo_desc;
    }
}