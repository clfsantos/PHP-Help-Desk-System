<?php
/**
 * Description of ProblemaManutencao
 *
 * @author cesantos
 */
class ProblemaManutencao {
    
    private $idProblema;
    private $descricaoProblema;
    
    public function __construct() {
        $this->idProblema = null;
        $this->descricaoProblema = null;
    }
    
    public function getIdProblema() {
        return $this->idProblema;
    }

    public function getDescricaoProblema() {
        return $this->descricaoProblema;
    }

    public function setIdProblema($idProblema) {
        $this->idProblema = $idProblema;
    }

    public function setDescricaoProblema($descricaoProblema) {
        $descricaoProblema = trim($descricaoProblema);
        if (strlen($descricaoProblema) < 2) {
            throw new Exception('A descrição do problema deve ter ao menos 2 caracteres!', 101);
        } elseif (strlen($descricaoProblema) > 60) {
            throw new Exception('A descrição do problema deve ter menos de 60 caracteres!', 102);
        }
        $this->descricaoProblema = $descricaoProblema;
    }
    
}
