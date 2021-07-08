<?php

/**
 * PainelDAO Geral
 *
 * @author cesantos
 */
class PainelDAO {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function implantacaoAndamento($usuario) {
        try {
            $query = "SELECT * "
                    . "FROM vw_etapa_chamado "
                    . "WHERE etapa_status_id = 2 AND setor_resp LIKE :busca "
                    . "ORDER BY spchamado_id ASC";
            $stmt = $this->conexao->prepare($query);
            $busca = "%," . $usuario . ",%";
            $stmt->bindValue(':busca', $busca, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $rows;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }
    
    public function implantacaoPendente($usuario) {
        try {
            $query = "SELECT * FROM vw_etapa_pendente WHERE prox_resp LIKE :busca "
                    . "ORDER BY spchamado_id ASC";
            $stmt = $this->conexao->prepare($query);
            $busca = "%," . $usuario . ",%";
            $stmt->bindValue(':busca', $busca, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $rows;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }
    
    public function implantacaoPendenteFinalizacao() {
        try {
            $query = "SELECT * FROM vw_etapa_pendente WHERE prox_resp IS NULL "
                    . "ORDER BY spchamado_id ASC";
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $rows;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

}
