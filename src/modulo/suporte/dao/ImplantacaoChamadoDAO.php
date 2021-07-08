<?php

/**
 * Description of ImplantacaoChamadoDAO
 *
 * @author cesantos
 */
class ImplantacaoChamadoDAO {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function concluirEtapa($etapaID,$etapaOBS) {
        try {
            $sql = "UPDATE spimplantacao_etapa_chamado "
                    . "SET etapa_status_id = 3, etapa_obs = ? "
                    . "WHERE id = ?";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindValue(1, $etapaOBS, PDO::PARAM_STR);
            $stmt->bindValue(2, $etapaID, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível concluir a etapa! - ' . $e->getMessage());
        }
    }
    
    public function salvarEtapa($etapaID,$etapaOBS) {
        try {
            $sql = "UPDATE spimplantacao_etapa_chamado "
                    . "SET etapa_obs = ? "
                    . "WHERE id = ?";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindValue(1, $etapaOBS, PDO::PARAM_STR);
            $stmt->bindValue(2, $etapaID, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível concluir a etapa! - ' . $e->getMessage());
        }
    }
    
    public function aprovarEtapa($etapaID) {
        try {
            $sql = "UPDATE spimplantacao_etapa_chamado "
                    . "SET etapa_status_id = 1 "
                    . "WHERE id = ?";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindValue(1, $etapaID, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível aprovar a etapa! - ' . $e->getMessage());
        }
    }
    
    public function recusarEtapa($etapaID,$etapaOBS) {
        try {
            $sql = "UPDATE spimplantacao_etapa_chamado "
                    . "SET etapa_status_id = 4, etapa_obs_recusada = ? "
                    . "WHERE id = ?";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindValue(1, $etapaOBS, PDO::PARAM_STR);
            $stmt->bindValue(2, $etapaID, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível concluir a etapa! - ' . $e->getMessage());
        }
    }

    public function listar($id, $offset, $rows, $sort, $order) {
        try {
            $query = "SELECT * "
                    . "FROM vw_etapa_chamado "
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
        $query = "SELECT count(id) "
                . "FROM vw_etapa_chamado "
                . "WHERE spchamado_id = :id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_NUM);
        return $row[0];
    }

    public function etapaAtualInfo($id) {
        try {
            $query = "SELECT * "
                    . "FROM vw_etapa_chamado "
                    . "WHERE etapa_status_id = 2 AND spchamado_id = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }
    
    public function listaProximasEtapas($id) {
        $query = "SELECT count(id) "
                . "FROM vw_etapa_chamado "
                . "WHERE spchamado_id = :id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_NUM);
        return $row[0];
    }
    
    public function usuarioEtapaAndamento($etapaID) {
        $query = "SELECT setor_resp FROM vw_etapa_chamado WHERE id = ?";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(1, $etapaID, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_NUM);
        return explode(',', $row[0]);
    }
    
    public function usuarioProximaEtapa($etapaID) {
        $query = "SELECT etapa_seq+1 FROM vw_etapa_chamado WHERE id = ?";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(1, $etapaID, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $query2 = "SELECT setor_resp FROM spimplantacao_etapa WHERE etapa_seq = ?";
        $stmt2 = $this->conexao->prepare($query2);
        $stmt2->bindValue(1, $row[0], PDO::PARAM_INT);
        $stmt2->execute();
        $row2 = $stmt2->fetch(PDO::FETCH_NUM);
        return explode(',', $row2[0]);
    }

}
