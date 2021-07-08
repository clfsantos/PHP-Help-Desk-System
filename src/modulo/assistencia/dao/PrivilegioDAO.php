<?php

/**
 * Description of PrivilegioDAO
 *
 * @author cesantos
 */
class PrivilegioDAO {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function VerificaPrivilegio($operacao, $tela, $usuario) {
        
        $op = "";
        if ($operacao === 'v') {
            $op = "visualizar";
        } elseif ($operacao === 'i') {
            $op = "incluir";
        } elseif ($operacao === 'a') {
            $op = "alterar";
        } elseif ($operacao === 'e') {
            $op = "excluir";
        }
        
        try {
            $sql = "SELECT " . $op . " AS permitido "
                    . "FROM privilegio "
                    . "INNER JOIN tela ON (tela.id = privilegio.tela_id) "
                    . "WHERE tela_id = ? AND usuario_id = ?";
            $stmt = $this->conexao->prepare($sql);
            //$stmt->bindValue(1, $operacao);
            $stmt->bindValue(1, $tela, PDO::PARAM_INT);
            $stmt->bindValue(2, $usuario, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['permitido'];
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível verificar a permissão do usuario! - ' . $e->getMessage());
        }
    }

}
