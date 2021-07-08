<?php

class ProdutoDAO {

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
                    . "FROM vw_produto "
                    . "WHERE LOWER(vdproduto_nome) LIKE LOWER(:busca) OR "
                    . "LOWER(vdproduto_cats) LIKE LOWER(:busca) "
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
                . "FROM vw_produto "
                . "WHERE LOWER(vdproduto_nome) LIKE LOWER(:busca) OR "
                . "LOWER(vdproduto_cats) LIKE LOWER(:busca)";
        $stmt = $this->conexao->prepare($query);
        $busca = "%" . $busca . "%";
        $stmt->bindValue(':busca', $busca, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function listarProduto($id) {
        try {
            $query = "SELECT * "
                    . "FROM vw_produto "
                    . "WHERE vdproduto_id = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

    public function listarAtributos($id) {
        try {
            $query = "SELECT * "
                    . "FROM vw_vdproduto_vdatributo "
                    . "WHERE vdproduto_id = ? "
                    . "ORDER BY vdatributo_desc ASC";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar os atributos! - ' . $e->getMessage());
        }
    }

}
