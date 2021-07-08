<?php

/**
 * Description of CategoriaDAO
 *
 * @author cesantos
 */
class CategoriaDAO {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function inserir($categoria) {
        try {
            $stmt = $this->conexao->prepare("INSERT INTO categoria (descricao_categoria) VALUES (?)");
            $stmt->bindValue(1, $categoria->getDescricao());
            $stmt->execute();
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '23505') {
                $motivo = 'A categoria (' . $categoria->getDescricao() . ') já está cadastrada e não pode ser duplicada. Tente fazer uma busca.';
            } else {
                $motivo = "Não foi possível incluir! Erro: " . $e->getMessage();
            }
            $mensagem = $motivo;
            throw new PDOException($mensagem);
        }
    }

    public function atualizar($categoria) {
        try {
            $stmt = $this->conexao->prepare("UPDATE categoria SET descricao_categoria=? WHERE id_categoria=?");
            $stmt->bindValue(1, $categoria->getDescricao());
            $stmt->bindValue(2, $categoria->getId());
            $stmt->execute();
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '23505') {
                $motivo = 'A categoria (' . $categoria->getDescricao() . ') já está cadastrada e não pode ser duplicada. Tente fazer uma busca.';
            } else {
                $motivo = "Não foi possível editar! Erro: " . $e->getMessage();
            }
            $mensagem = $motivo;
            throw new PDOException($mensagem);
        }
    }

    public function excluir($categoria) {
        try {
            $stmt = $this->conexao->prepare("DELETE FROM categoria WHERE id_categoria=?");
            $stmt->bindValue(1, $categoria->getId());
            $stmt->execute();
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '23503') {
                $motivo = 'Esta categoria está vinculada a outro processo!';
            } else {
                $motivo = $e->getMessage();
            }
            $mensagem = 'Não foi possível excluir - ' . $motivo;
            throw new PDOException($mensagem);
        }
    }

    public function listar($busca, $offset, $rows, $sort, $order) {
        try {
            $query = "SELECT id_categoria, descricao_categoria "
                    . "FROM categoria "
                    . "WHERE LOWER(descricao_categoria) LIKE LOWER(:busca) "
                    . "ORDER BY $sort $order "
                    . "LIMIT :rows OFFSET :offset";
            $stmt = $this->conexao->prepare($query);
            $busca = "%" . $busca . "%";
            $stmt->bindParam(':busca', $busca, PDO::PARAM_STR);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':rows', $rows, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

    public function contarBusca($busca) {
        $query = "SELECT id_categoria, descricao_categoria "
                . "FROM categoria "
                . "WHERE LOWER(descricao_categoria) LIKE LOWER(:busca)";
        $stmt = $this->conexao->prepare($query);
        $busca = "%" . $busca . "%";
        $stmt->bindParam(':busca', $busca, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function listarCategoria($id) {
        try {
            $query = "SELECT * "
                    . "FROM categoria "
                    . "WHERE id_categoria = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

}
