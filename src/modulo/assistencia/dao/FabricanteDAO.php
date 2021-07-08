<?php

/**
 * Description of FabricanteDAO
 *
 * @author cesantos
 */
class FabricanteDAO {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function inserir($fabricante) {
        try {
            $stmt = $this->conexao->prepare("INSERT INTO fabricante (nome_fabricante) VALUES (?)");
            $stmt->bindValue(1, $fabricante->getNome());
            $stmt->execute();
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '23505') {
                $motivo = 'O fabricante (' . $fabricante->getNome() . ') já está cadastrado e não pode ser duplicado. Tente fazer uma busca.';
            } else {
                $motivo = "Não foi possível incluir! Erro: " . $e->getMessage();
            }
            $mensagem = $motivo;
            throw new PDOException($mensagem);
        }
    }

    public function atualizar($fabricante) {
        try {
            $stmt = $this->conexao->prepare("UPDATE fabricante SET nome_fabricante=? WHERE codigo_fabricante=?");
            $stmt->bindValue(1, $fabricante->getNome());
            $stmt->bindValue(2, $fabricante->getCodigo());
            $stmt->execute();
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '23505') {
                $motivo = 'O fabricante (' . $fabricante->getNome() . ') já está cadastrado e não pode ser duplicado. Tente fazer uma busca.';
            } else {
                $motivo = "Não foi possível editar! Erro: " . $e->getMessage();
            }
            $mensagem = $motivo;
            throw new PDOException($mensagem);
        }
    }

    public function excluir($fabricante) {
        try {
            $stmt = $this->conexao->prepare("DELETE FROM fabricante WHERE codigo_fabricante=?");
            $stmt->bindValue(1, $fabricante->getCodigo());
            $stmt->execute();
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '23503') {
                $motivo = 'Este fabricante está vinculado a outro processo!';
            } else {
                $motivo = $e->getMessage();
            }
            $mensagem = 'Não foi possível excluir - ' . $motivo;
            throw new PDOException($mensagem);
        }
    }

    public function listar($busca, $offset, $rows, $sort, $order) {
        try {
            $query = "SELECT codigo_fabricante, nome_fabricante "
                    . "FROM fabricante "
                    . "WHERE LOWER(nome_fabricante) LIKE LOWER(:busca) "
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
        $query = "SELECT codigo_fabricante, nome_fabricante "
                . "FROM fabricante "
                . "WHERE LOWER(nome_fabricante) LIKE LOWER(:busca)";
        $stmt = $this->conexao->prepare($query);
        $busca = "%" . $busca . "%";
        $stmt->bindValue(':busca', $busca, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function listarFabricante($id) {
        try {
            $query = "SELECT * "
                    . "FROM fabricante "
                    . "WHERE codigo_fabricante = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

}
