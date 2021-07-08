<?php
/**
 * Description of Categoria
 *
 * @author cesantos
 */
class Categoria {
    
    private $id;
    private $descricao;
    
    public function __construct() {
        $this->id = 0;
        $this->descricao = "";
    }
    
    public function getId() {
        return $this->id;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setDescricao($descricao) {
        $descricao = trim($descricao);
        if (strlen($descricao) < 2) {
            throw new Exception('A descrição da categoria deve haver ao menos 2 caracteres!', 101);
        } elseif (strlen($descricao) > 60) {
            throw new Exception('A descrição da categoria deve haver menos de 60 caracteres!', 102);
        }
        $this->descricao = $descricao;
    }

}
