<?php

/**
 * Description of PainelDAO
 *
 * @author cesantos
 */
class PainelDAO {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function mediaDiasAssistencia() {
        try {
            $sql = "SELECT CEIL(AVG(dias_manutencao)) as media "
                    . "FROM vw_manutencao "
                    . "WHERE manutencao_ativa = false "
                    . "AND dias_manutencao > 5";
            $stmt = $this->conexao->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['media'];
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível obter a média! - ' . $e->getMessage());
        }
    }
    
    public function totalGeralAssistencia() {
        try {
            $sql = "SELECT count(*) as total "
                    . "FROM vw_manutencao";
            $stmt = $this->conexao->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total'];
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível obter o total! - ' . $e->getMessage());
        }
    }
    
    public function slaAssistenciaVencido() {
        try {
            $sql = "SELECT count(*) as total "
                    . "FROM det_assistencias_abertas() "
                    . "WHERE sla_vencido = true";
            $stmt = $this->conexao->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total'];
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível obter o total! - ' . $e->getMessage());
        }
    }
    
    public function slaVencido() {
        try {
            $sql = "SELECT * "
                    . "FROM det_assistencias_abertas() "
                    . "WHERE sla_vencido = true "
                    . "ORDER BY assistencia_id ASC";
            $stmt = $this->conexao->prepare($sql);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $rows;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível obter o total! - ' . $e->getMessage());
        }
    }
    
    public function assistenciasAbertas() {
        try {
            $sql = "SELECT count(*) as total "
                    . "FROM vw_manutencao "
                    . "WHERE manutencao_ativa = true";
            $stmt = $this->conexao->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total'];
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível obter o total! - ' . $e->getMessage());
        }
    }
    
    public function abertasMais30Dias() {
        try {
            $query = "SELECT * FROM det_assistencias_abertas() "
                    . "WHERE dias_manutencao > 29";
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $rows;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

}
