<?php
/**
 * Description of FollowupChamadoDAO
 *
 * @author cesantos
 */
class FollowupChamadoDAO {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function inserir($followupChamado) {
        try {
            $this->conexao->beginTransaction();
            $stmt = $this->conexao->prepare("INSERT INTO spfollowup (spfollowup_tipo, spfollowup_conteudo, spfollowup_usuario_id, spfollowup_usuario_trans) VALUES (?,?,?,?)");
            $stmt->bindValue(1, $followupChamado->getTipo());
            $stmt->bindValue(2, $followupChamado->getConteudo());
            $stmt->bindValue(3, $followupChamado->getUsuarioID());
            $stmt->bindValue(4, $followupChamado->getUsuarioTrans());
            $stmt->execute();
            $id = $this->conexao->lastInsertId('spfollowup_spfollowup_id_seq');
            $stmt = $this->conexao->prepare("INSERT INTO spchamado_followup (spchamado_id,spfollowup_id) VALUES (?,?)");
            $stmt->bindValue(1, $followupChamado->getChamadoID());
            $stmt->bindValue(2, $id, PDO::PARAM_INT);
            $stmt->execute();
            $this->conexao->commit();
        } catch (PDOException $e) {
            $this->conexao->rollBack();
            throw new PDOException('Não foi possível inserir! - ' . $e->getMessage());
        }
    }

    public function atualizar($followupChamado) {
        try {
            $stmt = $this->conexao->prepare("UPDATE spfollowup SET spfollowup_conteudo=? WHERE spfollowup_id=?");
            $stmt->bindValue(1, $followupChamado->getConteudo());
            $stmt->bindValue(2, $followupChamado->getFollowupID());
            $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível atualizar! - ' . $e->getMessage());
        }
    }

    public function excluir($followupChamado) {
        try {
            $stmt = $this->conexao->prepare("UPDATE spfollowup SET cancelado=true WHERE spfollowup_id=?");
            $stmt->bindValue(1, $followupChamado->getFollowupID());
            $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível cancelar! - ' . $e->getMessage());
        }
    }

    public function listar($id, $offset, $rows, $sort, $order) {
        try {
            $query = "SELECT * FROM vw_spchamado_followup "
                    . "WHERE spchamado_id = :id "
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
        $query = "SELECT count(spfollowup_id) FROM vw_spchamado_followup "
                . "WHERE spchamado_id = :id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_NUM);
        return $row[0];
    }

    public function listarFollowup($id) {
        try {
            $query = "SELECT * "
                    . "FROM vw_spchamado_followup "
                    . "WHERE spfollowup_id = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

}
