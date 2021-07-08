<?php
/**
 * Description of EventoFollowup
 *
 * @author cesantos
 */
class EventoFollowup {
    
    private $idEvento;
    private $descricaoEvento;
    private $prioridadeID;
    
    public function __construct() {
        $this->idEvento = null;
        $this->descricaoEvento = null;
    }
    
    public function getIdEvento() {
        return $this->idEvento;
    }

    public function getDescricaoEvento() {
        return $this->descricaoEvento;
    }
    
    function getPrioridadeID() {
        return $this->prioridadeID;
    }

    public function setIdEvento($idEvento) {
        $this->idEvento = $idEvento;
    }

    public function setDescricaoEvento($descricaoEvento) {
        $descricaoEvento = trim($descricaoEvento);
        if (strlen($descricaoEvento) < 2) {
            throw new Exception('A descrição do evento deve ter ao menos 2 caracteres!', 101);
        } elseif (strlen($descricaoEvento) > 60) {
            throw new Exception('A descrição do evento deve ter menos de 60 caracteres!', 102);
        }
        $this->descricaoEvento = $descricaoEvento;
    }
    
    function setPrioridadeID($prioridadeID) {
        $this->prioridadeID = $prioridadeID;
    }
    
}
