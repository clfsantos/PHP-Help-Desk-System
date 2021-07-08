<?php

/**
 * Description of ProblemaManutencaoDAO
 *
 * @author cesantos
 */
class ProblemaManutencaoDAO {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function inserir($problemaManutencao) {
        try {
            $stmt = $this->conexao->prepare("INSERT INTO problemamanutencao (descricao_problema) VALUES (UPPER(?))");
            $stmt->bindValue(1, $problemaManutencao->getDescricaoProblema());
            $stmt->execute();
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '23505') {
                $motivo = 'O problema (' . $problemaManutencao->getDescricaoProblema() . ') já está cadastrado e não pode ser duplicado. Tente fazer uma busca.';
            } else {
                $motivo = "Não foi possível incluir! Erro: " . $e->getMessage();
            }
            $mensagem = $motivo;
            throw new PDOException($mensagem);
        }
    }

    public function atualizar($problemaManutencao) {
        try {
            $stmt = $this->conexao->prepare("UPDATE problemamanutencao SET descricao_problema=UPPER(?) WHERE id_problema=?");
            $stmt->bindValue(1, $problemaManutencao->getDescricaoProblema());
            $stmt->bindValue(2, $problemaManutencao->getIdProblema());
            $stmt->execute();
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '23505') {
                $motivo = 'O problema (' . $problemaManutencao->getDescricaoProblema() . ') já está cadastrado e não pode ser duplicado. Tente fazer uma busca.';
            } else {
                $motivo = "Não foi possível editar! Erro: " . $e->getMessage();
            }
            $mensagem = $motivo;
            throw new PDOException($mensagem);
        }
    }

    public function excluir($problemaManutencao) {
        try {
            $stmt = $this->conexao->prepare("DELETE FROM problemamanutencao WHERE id_problema=?");
            $stmt->bindValue(1, $problemaManutencao->getIdProblema());
            $stmt->execute();
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '23503') {
                $motivo = 'Este problema está vinculado a outro processo!';
            } else {
                $motivo = $e->getMessage();
            }
            $mensagem = 'Não foi possível excluir - ' . $motivo;
            throw new PDOException($mensagem);
        }
    }

    public function listar($busca, $offset, $rows, $sort, $order) {
        try {
            $query = "SELECT id_problema, descricao_problema "
                    . "FROM problemamanutencao "
                    . "WHERE LOWER(descricao_problema) LIKE LOWER(:busca) "
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
        $query = "SELECT id_problema, descricao_problema "
                . "FROM problemamanutencao "
                . "WHERE LOWER(descricao_problema) LIKE LOWER(:busca)";
        $stmt = $this->conexao->prepare($query);
        $busca = "%" . $busca . "%";
        $stmt->bindValue(':busca', $busca, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function listarProblemaManutencao($id) {
        try {
            $query = "SELECT * "
                    . "FROM problemamanutencao "
                    . "WHERE id_problema = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

}
