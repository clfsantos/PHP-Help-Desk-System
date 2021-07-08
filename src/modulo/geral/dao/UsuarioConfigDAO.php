<?php

/**
 * Description of UsuarioDAO
 *
 * @author cesantos
 */
class UsuarioConfigDAO {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function mudarSenha($usuario) {
        try {
            $stmt = $this->conexao->prepare("UPDATE usuario SET senha=? where id=?");
            $stmt->bindValue(1, $usuario->getSenha());
            $stmt->bindValue(2, $usuario->getIdUsuario());
            $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível mudar a senha! - ' . $e->getMessage());
        }
    }
    
    public function mudarAvatar($usuario) {
        try {
            $stmt = $this->conexao->prepare("UPDATE usuario SET avatar=? where id=?");
            $stmt->bindValue(1, $usuario->getAvatar());
            $stmt->bindValue(2, $usuario->getIdUsuario());
            $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível mudar a foto! - ' . $e->getMessage());
        }
    }

    function checarSenha($usuario, $senha) {
        try {
            $sql = "select senha = '". $senha ."' as confere from usuario where id = ?";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindValue(1, $usuario->getIdUsuario());
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['confere'];
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível checar a senha atual! - ' . $e->getMessage());
        }
    }
    
    public function listarUsuario($id) {
        try {
            $query = "SELECT * "
                    . "FROM usuario "
                    . "WHERE id = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

}
