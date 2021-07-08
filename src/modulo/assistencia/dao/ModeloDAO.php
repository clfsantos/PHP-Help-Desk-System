<?php

/**
 * Description of ModeloDAO
 *
 * @author cesantos
 */
class ModeloDAO {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function inserir($modelo) {
        try {
            $stmt = $this->conexao->prepare("INSERT INTO modelo (id_categoria, codigo_fabricante, descricao) VALUES (?,?,?)");
            $stmt->bindValue(1, $modelo->getIdCategoria());
            $stmt->bindValue(2, $modelo->getCodigoFabricante());
            $stmt->bindValue(3, $modelo->getDescricao());
            $stmt->execute();
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '23505') {
                $motivo = 'O modelo (' . $modelo->getDescricao() . ') já está cadastrado e não pode ser duplicado. Tente fazer uma busca.';
            } else {
                $motivo = "Não foi possível incluir! Erro: " . $e->getMessage();
            }
            $mensagem = $motivo;
            throw new PDOException($mensagem);
        }
    }

    public function atualizar($modelo) {
        try {
            $stmt = $this->conexao->prepare("UPDATE modelo SET id_categoria=?, codigo_fabricante=?, descricao=? WHERE id_modelo=?");
            $stmt->bindValue(1, $modelo->getIdCategoria());
            $stmt->bindValue(2, $modelo->getCodigoFabricante());
            $stmt->bindValue(3, $modelo->getDescricao());
            $stmt->bindValue(4, $modelo->getCodigo());
            $stmt->execute();
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '23505') {
                $motivo = 'O modelo (' . $modelo->getDescricao() . ') já está cadastrado e não pode ser duplicado. Tente fazer uma busca.';
            } else {
                $motivo = "Não foi possível editar! Erro: " . $e->getMessage();
            }
            $mensagem = $motivo;
            throw new PDOException($mensagem);
        }
    }

    public function excluir($modelo) {
        try {
            $stmt = $this->conexao->prepare("DELETE FROM modelo WHERE id_modelo=?");
            $stmt->bindValue(1, $modelo->getCodigo());
            $stmt->execute();
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '23503') {
                $motivo = 'Este modelo está vinculado a outro processo!';
            } else {
                $motivo = $e->getMessage();
            }
            $mensagem = 'Não foi possível excluir - ' . $motivo;
            throw new PDOException($mensagem);
        }
    }

    public function listar($busca, $offset, $rows, $sort, $order) {
        try {
            $query = "SELECT * FROM vw_modelos "
                    . "WHERE LOWER(descricao) LIKE LOWER(:busca) "
                    . "OR LOWER(nome_fabricante) LIKE LOWER(:busca) "
                    . "OR LOWER(descricao_categoria) LIKE LOWER(:busca) "
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
        $query = "SELECT * FROM vw_modelos "
                . "WHERE LOWER(descricao) LIKE LOWER(:busca) "
                . "OR LOWER(nome_fabricante) LIKE LOWER(:busca) "
                . "OR LOWER(descricao_categoria) LIKE LOWER(:busca)";
        $stmt = $this->conexao->prepare($query);
        $busca = '%' . $busca . '%';
        $stmt->bindValue(':busca', $busca, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function listarModelo($id) {
        try {
            $query = "SELECT * "
                    . "FROM vw_modelos "
                    . "WHERE id_modelo = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

}
