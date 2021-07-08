<?php

/**
 * Description of EventoFollowupDAO
 *
 * @author cesantos
 */
class EventoFollowupDAO {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function inserir($eventoFollowup) {
        try {
            $stmt = $this->conexao->prepare("INSERT INTO eventofollowup (descricao_evento, prioridade_id) VALUES (UPPER(?),?)");
            $stmt->bindValue(1, $eventoFollowup->getDescricaoEvento(), PDO::PARAM_STR);
            $stmt->bindValue(2, $eventoFollowup->getPrioridadeID(), PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '23505') {
                $motivo = 'O evento (' . $eventoFollowup->getDescricaoEvento() . ') já está cadastrado e não pode ser duplicado. Tente fazer uma busca.';
            } else {
                $motivo = "Não foi possível incluir! Erro: " . $e->getMessage();
            }
            $mensagem = $motivo;
            throw new PDOException($mensagem);
        }
    }

    public function atualizar($eventoFollowup) {
        try {
            $stmt = $this->conexao->prepare("UPDATE eventofollowup SET descricao_evento=UPPER(?), prioridade_id=? WHERE id_evento=?");
            $stmt->bindValue(1, $eventoFollowup->getDescricaoEvento(), PDO::PARAM_STR);
            $stmt->bindValue(2, $eventoFollowup->getPrioridadeID(), PDO::PARAM_INT);
            $stmt->bindValue(3, $eventoFollowup->getIdEvento(), PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '23505') {
                $motivo = 'O evento (' . $eventoFollowup->getDescricaoEvento() . ') já está cadastrado e não pode ser duplicado. Tente fazer uma busca.';
            } else {
                $motivo = "Não foi possível editar! Erro: " . $e->getMessage();
            }
            $mensagem = $motivo;
            throw new PDOException($mensagem);
        }
    }

    public function excluir($eventoFollowup) {
        try {
            $stmt = $this->conexao->prepare("DELETE FROM eventofollowup WHERE id_evento=?");
            $stmt->bindValue(1, $eventoFollowup->getIdEvento(), PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '23503') {
                $motivo = 'Este evento está vinculado a outro processo!';
            } else {
                $motivo = $e->getMessage();
            }
            $mensagem = 'Não foi possível excluir - ' . $motivo;
            throw new PDOException($mensagem);
        }
    }

    public function listar($busca, $offset, $rows, $sort, $order) {
        try {
            $query = "SELECT id_evento, descricao_evento, prioridade_id "
                    . "FROM eventofollowup "
                    . "WHERE LOWER(descricao_evento) LIKE LOWER(:busca) "
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
        $query = "SELECT id_evento, descricao_evento, prioridade_id "
                . "FROM eventofollowup "
                . "WHERE LOWER(descricao_evento) LIKE LOWER(:busca)";
        $stmt = $this->conexao->prepare($query);
        $busca = "%" . $busca . "%";
        $stmt->bindValue(':busca', $busca, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function buscarEvento($id) {
        $query = "SELECT descricao_evento FROM eventofollowup "
                . "WHERE id_evento = :id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $evento = $stmt->fetch(PDO::FETCH_ASSOC);
        return $evento['descricao_evento'];
    }

    public function listarEventoFollowup($id) {
        try {
            $query = "SELECT * "
                    . "FROM eventofollowup "
                    . "WHERE id_evento = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

}
