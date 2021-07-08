<?php

class GrupoChamado {
    private $spchamado_grupo_id;
    private $spchamado_grupo_desc;
    
    function __construct() {
        $this->spchamado_grupo_id = null;
        $this->spchamado_grupo_desc = null;
    }
    
    function getSpchamado_grupo_id() {
        return $this->spchamado_grupo_id;
    }

    function getSpchamado_grupo_desc() {
        return $this->spchamado_grupo_desc;
    }

    function setSpchamado_grupo_id($spchamado_grupo_id) {
        $this->spchamado_grupo_id = $spchamado_grupo_id;
    }

    function setSpchamado_grupo_desc($spchamado_grupo_desc) {
        $spchamado_grupo_desc = trim($spchamado_grupo_desc);
        if(empty($spchamado_grupo_desc)) {
            throw new Exception("A descrição do grupo não pode estar em branco", 102);
        }
        $this->spchamado_grupo_desc = $spchamado_grupo_desc;
    }

}