<?php

/**
 * Description of EstadoDAO
 *
 * @author Cesar
 */
class EstadoDAO {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function cadastrar($estado) {
        try {
            $stmt = $this->conexao->prepare("INSERT INTO estado (nome,sigla) VALUES (?,upper(?))");
            $stmt->bindValue(1, $estado->getNome());
            $stmt->bindValue(2, $estado->getSigla());
            $stmt->execute();
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '23505') {
                $motivo = 'O estado (' . $estado->getNome() . ') já está cadastrado e não pode ser duplicado. Tente fazer uma busca.';
            } else {
                $motivo = "Não foi possível incluir! Erro: " . $e->getMessage();
            }
            $mensagem = $motivo;
            throw new PDOException($mensagem);
        }
    }

    public function editar($estado) {
        try {
            $stmt = $this->conexao->prepare("UPDATE estado SET nome=?, sigla=upper(?) WHERE id=?");
            $stmt->bindValue(1, $estado->getNome());
            $stmt->bindValue(2, $estado->getSigla());
            $stmt->bindValue(3, $estado->getId());
            $stmt->execute();
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '23505') {
                $motivo = 'O estado (' . $estado->getNome() . ') já está cadastrado e não pode ser duplicado. Tente fazer uma busca.';
            } else {
                $motivo = "Não foi possível editar! Erro: " . $e->getMessage();
            }
            $mensagem = $motivo;
            throw new PDOException($mensagem);
        }
    }

    public function excluir($estado) {
        try {
            $stmt = $this->conexao->prepare("DELETE FROM estado WHERE id=?");
            $stmt->bindValue(1, $estado->getId());
            $stmt->execute();
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '23503') {
                $motivo = 'Este estado está vinculado a outro processo!';
            } else {
                $motivo = $e->getMessage();
            }
            $mensagem = 'Não foi possível excluir - ' . $motivo;
            throw new PDOException($mensagem);
        }
    }

    public function listar($busca, $offset, $rows, $sort, $order) {
        try {
            $query = "SELECT * "
                    . "FROM estado "
                    . "WHERE LOWER(nome) LIKE LOWER(:busca) "
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
        $query = "SELECT * "
                . "FROM estado "
                . "WHERE LOWER(nome) LIKE LOWER(:busca)";
        $stmt = $this->conexao->prepare($query);
        $busca = "%" . $busca . "%";
        $stmt->bindValue(':busca', $busca, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function listarEstado($id) {
        try {
            $query = "SELECT * "
                    . "FROM estado "
                    . "WHERE id = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

}
