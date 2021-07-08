<?php

/**
 * Description of ManutencaoDAO
 *
 * @author cesantos
 */
class ManutencaoDAO {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function inserir($manutencao) {
        try {
            $query = "INSERT INTO manutencao (codigo_equipamento,id_problema,problema_inicial,data_entrada,nota_fiscal) "
                    . "VALUES (?,?,?,?,?)";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $manutencao->getCodigoEquipamento());
            $stmt->bindValue(2, $manutencao->getIdProblema());
            $stmt->bindValue(3, $manutencao->getProblemaInicial());
            $stmt->bindValue(4, $manutencao->getDataEntrada());
            $stmt->bindValue(5, $manutencao->getNotaFiscal());
            $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível inserir! - ' . $e->getMessage());
        }
    }

    public function atualizar($manutencao) {
        try {
            $query = "UPDATE manutencao SET codigo_equipamento=?,id_problema=?,problema_inicial=?,data_entrada=?,data_devolucao=?,laudo_tecnico=?,manutencao_ativa=?,nota_fiscal=? "
                    . "WHERE id_manutencao=?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $manutencao->getCodigoEquipamento());
            $stmt->bindValue(2, $manutencao->getIdProblema());
            $stmt->bindValue(3, $manutencao->getProblemaInicial());
            $stmt->bindValue(4, $manutencao->getDataEntrada());
            $stmt->bindValue(5, $manutencao->getDataSaida());
            $stmt->bindValue(6, $manutencao->getLaudoTecnico());
            $stmt->bindValue(7, $manutencao->getManutencaoAtiva());
            $stmt->bindValue(8, $manutencao->getNotaFiscal());
            $stmt->bindValue(9, $manutencao->getIdManutencao());
            $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível atualizar! - ' . $e->getMessage());
        }
    }

    public function excluir($manutencao) {
        try {
            $stmt = $this->conexao->prepare("DELETE FROM manutencao WHERE id_manutencao=?");
            $stmt->bindValue(1, $manutencao->getIdManutencao());
            $stmt->execute();
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '23503') {
                $motivo = 'Esta manutenção está vinculado a outro processo!';
            } else {
                $motivo = $e->getMessage();
            }
            $mensagem = 'Não foi possível excluir - ' . $motivo;
            throw new PDOException($mensagem);
        }
    }

    public function listar($buscapm, $busca, $offset, $rows, $sort, $order) {
        try {
            $query = "SELECT * FROM vw_manutencao "
                    . "WHERE (LOWER(crcliente_fantasia) LIKE LOWER(:busca) OR LOWER(nr_serie) LIKE LOWER(:busca) OR LOWER(descricao) LIKE LOWER(:busca)) "
                    . "AND (manutencao_ativa = :buscastatus1 OR manutencao_ativa = :buscastatus2) "
                    . "ORDER BY $sort $order "
                    . "LIMIT :rows OFFSET :offset";
            $stmt = $this->conexao->prepare($query);
            $busca = "%" . $busca . "%";
            $buscastatus1 = false;
            $buscastatus2 = true;
            if ($buscapm === "finalizado") {
                $buscastatus2 = false;
            } elseif ($buscapm === "aberto") {
                $buscastatus1 = true;
            }
            $stmt->bindValue(':buscastatus1', $buscastatus1, PDO::PARAM_BOOL);
            $stmt->bindValue(':buscastatus2', $buscastatus2, PDO::PARAM_BOOL);
            $stmt->bindValue(':busca', $busca, PDO::PARAM_STR);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindValue(':rows', $rows, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

    public function contarBusca($buscapm, $busca) {
        $query = "SELECT * FROM vw_manutencao "
                . "WHERE (LOWER(crcliente_fantasia) LIKE LOWER(:busca) OR LOWER(nr_serie) LIKE LOWER(:busca) OR LOWER(descricao) LIKE LOWER(:busca)) "
                . "AND (manutencao_ativa = :buscastatus1 OR manutencao_ativa = :buscastatus2)";
        $stmt = $this->conexao->prepare($query);
        $busca = "%" . $busca . "%";
        $buscastatus1 = false;
        $buscastatus2 = true;
        if ($buscapm === "finalizado") {
            $buscastatus2 = false;
        } elseif ($buscapm === "aberto") {
            $buscastatus1 = true;
        }
        $stmt->bindValue(':buscastatus1', $buscastatus1, PDO::PARAM_BOOL);
        $stmt->bindValue(':buscastatus2', $buscastatus2, PDO::PARAM_BOOL);
        $stmt->bindValue(':busca', $busca, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function detalhesManutencao($id) {
        try {
            $stmt = $this->conexao->prepare("SELECT * FROM vw_manutencao WHERE id_manutencao = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetch(PDO::FETCH_ASSOC);
            return $rows;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

    public function detalhesManutencaoFollowup($id) {
        try {
            $stmt = $this->conexao->prepare("SELECT * FROM vw_followups WHERE id_manutencao = :id ORDER BY id_followup ASC");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $rows;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }
    
    public function historicoManutencao($equipamentoID, $manutencaoID) {
        try {
            $stmt = $this->conexao->prepare("SELECT * FROM vw_manutencao WHERE codigo_equipamento = :ide and id_manutencao < :idm ORDER BY id_manutencao DESC");
            $stmt->bindValue(':ide', $equipamentoID, PDO::PARAM_INT);
            $stmt->bindValue(':idm', $manutencaoID, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $rows;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }
    
    public function historicoChamado($clienteID, $dt_manutencao) {
        try {
            $stmt = $this->conexao->prepare("SELECT * FROM vw_spchamado WHERE crcliente_id = ? AND spchamado_dt_abertura <= ?");
            $stmt->bindValue(1, $clienteID, PDO::PARAM_INT);
            $stmt->bindValue(2, $dt_manutencao, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $rows;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

    public function listarManutencao($id) {
        try {
            $query = "SELECT * "
                    . "FROM vw_manutencao "
                    . "WHERE id_manutencao = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

}
