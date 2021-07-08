<?php

/**
 * Description of TarefaChamadoDAO
 *
 * @author cesantos
 */
class TarefaChamadoDAO {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function inserir($tarefaChamado) {
        try {
            $sql = "INSERT INTO sptarefa "
                    . "(spchamado_id, sptarefa_duracao, sptarefa_dt_tarefa, sptarefa_dt_vto, sptarefa_titulo, sptarefa_desc, sptarefa_usuario, sptarefa_u_atribuido) "
                    . "VALUES (?,?,?,?,?,?,?,?)";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindValue(1, $tarefaChamado->getChamadoID());
            $stmt->bindValue(2, $tarefaChamado->getDuracao());
            $stmt->bindValue(3, $tarefaChamado->getDtTarefa());
            $stmt->bindValue(4, $tarefaChamado->getDtVencimento());
            $stmt->bindValue(5, $tarefaChamado->getTitulo());
            $stmt->bindValue(6, $tarefaChamado->getDescricao());
            $stmt->bindValue(7, $tarefaChamado->getUsuarioID());
            $stmt->bindValue(8, $tarefaChamado->getUsuarioAtribuicao());
            $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível inserir! - ' . $e->getMessage());
        }
    }

    public function atualizar($tarefaChamado) {
        try {
            $sql = "UPDATE sptarefa SET "
                    . "sptarefa_status=?, sptarefa_duracao=?, sptarefa_dt_tarefa=?, sptarefa_dt_vto=?, sptarefa_titulo=?, sptarefa_desc=?, sptarefa_usuario=?, sptarefa_u_atribuido=?, sptarefa_cancelada=? "
                    . "WHERE sptarefa_id = ?";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindValue(1, $tarefaChamado->getStatus());
            $stmt->bindValue(2, $tarefaChamado->getDuracao());
            $stmt->bindValue(3, $tarefaChamado->getDtTarefa());
            $stmt->bindValue(4, $tarefaChamado->getDtVencimento());
            $stmt->bindValue(5, $tarefaChamado->getTitulo());
            $stmt->bindValue(6, $tarefaChamado->getDescricao());
            $stmt->bindValue(7, $tarefaChamado->getUsuarioID());
            $stmt->bindValue(8, $tarefaChamado->getUsuarioAtribuicao());
            $stmt->bindValue(9, $tarefaChamado->getCancelada());
            $stmt->bindValue(10, $tarefaChamado->getTarefaID());
            $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível atualizar! - ' . $e->getMessage());
        }
    }

    public function excluir($tarefaChamado) {
        try {
            $stmt = $this->conexao->prepare("DELETE FROM sptarefa WHERE sptarefa_id = ?");
            $stmt->bindValue(1, $tarefaChamado->getTarefaID());
            $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível excluir! - ' . $e->getMessage());
        }
    }

    public function listar($id, $offset, $rows, $sort, $order) {
        try {
            $query = "SELECT * "
                    . "FROM vw_tarefa "
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
        $query = "SELECT count(sptarefa_id) "
                . "FROM vw_tarefa "
                . "WHERE spchamado_id = :id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_NUM);
        return $row[0];
    }

    public function listarTarefaChamado($id) {
        try {
            $query = "SELECT * "
                    . "FROM sptarefa "
                    . "WHERE sptarefa_id = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

}
