<?php

/**
 * Description of ListaDAO
 *
 * @author Cesar
 */
class ListaDAO {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function cadastrar($lista) {
        try {
            $stmt = $this->conexao->prepare("INSERT INTO lista (descricao) VALUES (?)");
            $stmt->bindValue(1, $lista->getDescricao());
            $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível inserir! - ' . $e->getMessage());
        }
    }

    public function editar($lista) {
        try {
            $stmt = $this->conexao->prepare("UPDATE lista SET descricao=? WHERE id=?");
            $stmt->bindValue(1, $lista->getDescricao());
            $stmt->bindValue(2, $lista->getId());
            $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível atualizar! - ' . $e->getMessage());
        }
    }

    public function excluir($lista) {
        try {
            $stmt = $this->conexao->prepare("DELETE FROM lista WHERE id=?");
             $stmt->bindValue(1, $lista->getId());
            $stmt->execute();
        } catch (PDOException $e) {
            $mensagem = 'Não foi possível excluir! - ' . $e->getMessage();
            throw new PDOException($mensagem);
        }
    }

    public function listar($busca, $offset, $rows, $sort, $order) {
        try {
            $query = "SELECT * "
                    . "FROM lista "
                    . "WHERE LOWER(descricao) LIKE LOWER(:busca) "
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
                . "FROM lista "
                . "WHERE LOWER(descricao) LIKE LOWER(:busca)";
        $stmt = $this->conexao->prepare($query);
        $busca = "%" . $busca . "%";
        $stmt->bindValue(':busca', $busca, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount();
    }
    
    public function listarLista($id) {
        try {
            $query = "SELECT * "
                    . "FROM lista "
                    . "WHERE id = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }
    
    public function listarTudo() {
        try {
            $query = "SELECT * "
                    . "FROM lista "
                    . "ORDER BY descricao asc";
            $stmt = $this->conexao->query($query);
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar tudo! - ' . $e->getMessage());
        }
    }

}
