<?php

/**
 * Description of OrigemChamadoDAO
 *
 * @author cesantos
 */
class OrigemChamadoDAO {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function inserir($equipamento) {
        try {
            $query = "INSERT INTO equipamento (nr_serie,crcliente_id,id_modelo) "
                    . "VALUES (UPPER(?),?,?)";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $equipamento->getNrSerie());
            $stmt->bindValue(2, $equipamento->getCodigoEmpresa());
            $stmt->bindValue(3, $equipamento->getIdModelo());
            $stmt->execute();
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '23505') {
                $motivo = 'O equipamento (' . $equipamento->getNrSerie() . ') já está cadastrado e não pode ser duplicado. Tente fazer uma busca.';
            } else {
                $motivo = "Não foi possível incluir! Erro: " . $e->getMessage();
            }
            $mensagem = $motivo;
            throw new PDOException($mensagem);
        }
    }

    public function atualizar($equipamento) {
        try {
            $query = "UPDATE equipamento SET nr_serie=UPPER(?),crcliente_id=?,id_modelo=? "
                    . "WHERE codigo_equipamento=?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $equipamento->getNrSerie());
            $stmt->bindValue(2, $equipamento->getCodigoEmpresa());
            $stmt->bindValue(3, $equipamento->getIdModelo());
            $stmt->bindValue(4, $equipamento->getCodigo());
            $stmt->execute();
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '23505') {
                $motivo = 'O equipamento (' . $equipamento->getNrSerie() . ') já está cadastrado e não pode ser duplicado. Tente fazer uma busca.';
            } else {
                $motivo = "Não foi possível editar! Erro: " . $e->getMessage();
            }
            $mensagem = $motivo;
            throw new PDOException($mensagem);
        }
    }

    public function excluir($equipamento) {
        try {
            $stmt = $this->conexao->prepare("DELETE FROM equipamento WHERE codigo_equipamento=?");
            $stmt->bindValue(1, $equipamento->getCodigo());
            $stmt->execute();
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '23503') {
                $motivo = 'Este equipamento está vinculado a outro processo!';
            } else {
                $motivo = $e->getMessage();
            }
            $mensagem = 'Não foi possível excluir - ' . $motivo;
            throw new PDOException($mensagem);
        }
    }

    public function listar($busca, $offset, $rows, $sort, $order) {
        try {
            $query = "SELECT * FROM vw_spchamado "
                    . "WHERE LOWER(crcliente_razao) LIKE LOWER(:busca) "
                    . "OR LOWER(crcliente_fantasia) LIKE LOWER(:busca) "
                    . "OR LOWER(spchamado_contato) LIKE LOWER(:busca) "
                    . "ORDER BY $sort $order "
                    . "LIMIT :rows OFFSET :offset";
            $stmt = $this->conexao->prepare($query);
            $busca = "%" . $busca . "%";
            $stmt->bindValue(':busca', $busca, PDO::PARAM_STR);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindValue(':rows', $rows, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

    public function contarBusca($busca) {
        $query = "SELECT * FROM vw_spchamado "
                . "WHERE LOWER(crcliente_razao) LIKE LOWER(:busca) "
                . "OR LOWER(crcliente_fantasia) LIKE LOWER(:busca) "
                . "OR LOWER(spchamado_contato) LIKE LOWER(:busca)";
        $stmt = $this->conexao->prepare($query);
        $busca = "%" . $busca . "%";
        $stmt->bindValue(':busca', $busca, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function listarChamado($id) {
        try {
            $query = "SELECT * "
                    . "FROM vw_spchamado "
                    . "WHERE spchamado_id = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }
    
    public function origemChamadoCombo() {
        try {
            $query = "SELECT spchamado_origem.spchamado_origem_id, spchamado_origem.spchamado_origem_desc FROM spchamado_origem";
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

}
