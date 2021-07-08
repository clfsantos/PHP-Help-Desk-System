<?php

class EnvioDAO {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function cadastrar($atributo) {
        try {
            $this->conexao->beginTransaction();
            $query = "INSERT INTO atributo (nome,tipo,discriminante,grupo_id) VALUES (?,?,?,?)";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $atributo->getNome());
            $stmt->bindValue(2, $atributo->getTipo());
            $stmt->bindValue(3, $atributo->getDiscriminante());
            $stmt->bindValue(4, $atributo->getGrupoID());
            $stmt->execute();
            $atributo_id = $this->conexao->lastInsertId('atributo_id_seq');
            $query = "INSERT INTO atributo_peso (atributo_id,peso) VALUES (?,?)";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $atributo_id, PDO::PARAM_INT);
            $stmt->bindValue(2, $atributo->getPeso());
            $stmt->execute();
            $this->conexao->commit();
        } catch (PDOException $e) {
            $this->conexao->rollBack();
            throw new PDOException('Não foi possível inserir! - ' . $e->getMessage());
        }
    }

    public function editar($atributo) {
        try {
            $this->conexao->beginTransaction();
            $query = "UPDATE atributo SET nome=?,tipo=?,discriminante=?,grupo_id=? "
                    . "WHERE id = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $atributo->getNome());
            $stmt->bindValue(2, $atributo->getTipo());
            $stmt->bindValue(3, $atributo->getDiscriminante());
            $stmt->bindValue(4, $atributo->getGrupoID());
            $stmt->bindValue(5, $atributo->getAtributoID());
            $stmt->execute();
            $query = "UPDATE atributo_peso SET peso=? WHERE atributo_id = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $atributo->getPeso());
            $stmt->bindValue(2, $atributo->getAtributoID());
            $stmt->execute();
            $this->conexao->commit();
        } catch (PDOException $e) {
            $this->conexao->rollBack();
            throw new PDOException('Não foi possível editar! - ' . $e->getMessage());
        }
    }

    public function excluir($atributo) {
        try {
            $this->conexao->beginTransaction();
            $stmt = $this->conexao->prepare("DELETE FROM atributo_peso WHERE atributo_id = ?");
            $stmt->bindValue(1, $atributo->getAtributoID());
            $stmt->execute();
            $stmt = $this->conexao->prepare("DELETE FROM atributo WHERE id = ?");
            $stmt->bindValue(1, $atributo->getAtributoID());
            $stmt->execute();
            $this->conexao->commit();
        } catch (PDOException $e) {
            $this->conexao->rollBack();
            throw new PDOException('Não foi possível excluir! - ' . $e->getMessage());
        }
    }

    public function listar($busca, $offset, $rows, $sort, $order) {
        try {
            $query = "SELECT id, titulo, data_envio, status "
                    . "FROM envio "
                    . "WHERE LOWER(titulo) LIKE LOWER(:busca) "
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
        $query = "SELECT id, titulo, data_envio, status "
                . "FROM envio "
                . "WHERE LOWER(titulo) LIKE LOWER(:busca)";
        $stmt = $this->conexao->prepare($query);
        $busca = "%" . $busca . "%";
        $stmt->bindValue(':busca', $busca, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount();
    }

}
