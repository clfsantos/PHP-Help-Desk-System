<?php

/**
 * Description of UsuarioDAO
 *
 * @author cesantos
 */
class UsuarioDAO {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    public function cbUsuariosTec() {
        try {
            $query = "SELECT id, nome "
                    . "FROM usuario "
                    . "WHERE ativo = true "
                    . "ORDER BY nome ASC";
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

}
