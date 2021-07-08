<?php

/**
 * Description of FollowupDAO
 *
 * @author cesantos
 */
class FollowupDAO {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function inserir($followup) {
        try {
            $this->conexao->beginTransaction();
            $stmt = $this->conexao->prepare("INSERT INTO followup (conteudo, id_evento, usuario_id) VALUES (?,?,?)");
            $stmt->bindValue(1, $followup->getConteudo());
            $stmt->bindValue(2, $followup->getIdEvento());
            $stmt->bindValue(3, $followup->getIdUsuario());
            $stmt->execute();
            $id = $this->conexao->lastInsertId('followup_id_followup_seq');
            $stmt = $this->conexao->prepare("INSERT INTO manutencaofollowup (id_manutencao,id_followup) VALUES (?,?)");
            $stmt->bindValue(1, $followup->getIdManutencao());
            $stmt->bindValue(2, $id, PDO::PARAM_INT);
            $stmt->execute();
            $this->conexao->commit();
        } catch (PDOException $e) {
            $this->conexao->rollBack();
            throw new PDOException('Não foi possível inserir! - ' . $e->getMessage());
        }
    }

    public function atualizar($followup) {
        try {
            $stmt = $this->conexao->prepare("UPDATE followup SET conteudo=?, id_evento=? WHERE id_followup=?");
            $stmt->bindValue(1, $followup->getConteudo());
            $stmt->bindValue(2, $followup->getIdEvento());
            $stmt->bindValue(3, $followup->getIdFollowp());
            $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível atualizar! - ' . $e->getMessage());
        }
    }

    public function excluir($followup) {
        try {
            $this->conexao->beginTransaction();
            $stmt = $this->conexao->prepare("DELETE FROM manutencaofollowup WHERE id_followup=?");
            $stmt->bindValue(1, $followup->getIdFollowp());
            $stmt->execute();
            $stmt = $this->conexao->prepare("DELETE FROM followup WHERE id_followup=?");
            $stmt->bindValue(1, $followup->getIdFollowp());
            $stmt->execute();
            $this->conexao->commit();
        } catch (PDOException $e) {
            $this->conexao->rollBack();
            throw new PDOException('Não foi possível excluir! - ' . $e->getMessage());
        }
    }

    public function listar($id, $offset, $rows, $sort, $order) {
        try {
            $query = "SELECT * FROM vw_followups "
                    . "WHERE id_manutencao = :id "
                    . "ORDER BY $sort $order "
                    . "LIMIT :rows OFFSET :offset";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindValue(':rows', $rows, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

    public function contarBusca($id) {
        $query = "SELECT * FROM vw_followups "
                . "WHERE id_manutencao = :id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function enviarEmail($followup) {
        try {
            $query = "SELECT crcliente_email FROM vw_manutencao where id_manutencao = :id";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(':id', $followup->getIdManutencao(), PDO::PARAM_INT);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            $followup->enviarEmail($resultado['crcliente_email']);
        } catch (Exception $ex) {
            throw new Exception('Não foi possível enviar o e-mail! - ' . $ex->getMessage());
        }
    }
    
    public function listarFollowup($id) {
        try {
            $query = "SELECT * "
                    . "FROM vw_followups "
                    . "WHERE id_followup = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

}
