<?php

/**
 * Description of FollowupChamado
 *
 * @author cesantos
 */
class FollowupChamado {

    private $followupID;
    private $chamadoID;
    private $tipo;
    private $conteudo;
    private $usuarioID;
    private $usuarioTrans;

    function __construct() {
        $this->followupID = null;
        $this->chamadoID = null;
        $this->tipo = null;
        $this->conteudo = null;
        $this->usuarioID = null;
        $this->usuarioTrans = null;
    }

    function getFollowupID() {
        return $this->followupID;
    }

    function getChamadoID() {
        return $this->chamadoID;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getConteudo() {
        return $this->conteudo;
    }

    function getUsuarioID() {
        return $this->usuarioID;
    }

    function getUsuarioTrans() {
        return $this->usuarioTrans;
    }

    function setFollowupID($followupID) {
        if (!preg_match("/^\d+$/", $followupID)) {
            throw new Exception('ID do followup inválido!', 101);
        }
        $this->followupID = $followupID;
    }

    function setChamadoID($chamadoID) {
        if (!preg_match("/^\d+$/", $chamadoID)) {
            throw new Exception('ID do chamado inválido!', 102);
        }
        $this->chamadoID = $chamadoID;
    }

    function setTipo($tipo) {
        if (!preg_match("/^\d+$/", $tipo)) {
            throw new Exception('Tipo inválido!', 103);
        }
        $this->tipo = $tipo;
    }

    function setConteudo($conteudo) {
        $conteudo = trim($conteudo);
        if (strlen($conteudo) < 5) {
            throw new Exception('O conteúdo do followup deve ter ao menos 5 caracteres!', 104);
        }
        $this->conteudo = $conteudo;
    }

    function setUsuarioID($usuarioID) {
        if (!preg_match("/^\d+$/", $usuarioID)) {
            throw new Exception('ID do usuário inválido!', 105);
        }
        $this->usuarioID = $usuarioID;
    }

    function setUsuarioTrans($usuarioTrans) {
        if ($this->tipo === '2') {
            if (!preg_match("/^\d+$/", $usuarioTrans)) {
                throw new Exception('Escolha o usuário para a transferência', 106);
            }
            $this->usuarioTrans = $usuarioTrans;
        } elseif ($this->tipo === '1' && !empty($usuarioTrans)) {
            throw new Exception('Não pode haver transferência no followup de seguimento', 106);
        } else {
            if (empty($usuarioTrans)) {
                $this->usuarioTrans = null;
            } else {
                if (!preg_match("/^\d+$/", $usuarioTrans)) {
                    throw new Exception('ID do usuário inválido!', 106);
                }
                $this->usuarioTrans = $usuarioTrans;
            }
        }
    }

}
