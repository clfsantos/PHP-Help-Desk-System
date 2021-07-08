<?php

/**
 * Description of CidadeDAO
 *
 * @author Cesar
 */
class CidadeDAO {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function cadastrar($cidade) {
        try {
            $stmt = $this->conexao->prepare("INSERT INTO cidade (nome,estado_id) VALUES (?,?)");
            $stmt->bindValue(1, $cidade->getNome());
            $stmt->bindValue(2, $cidade->getEstadoID());
            $stmt->execute();
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '23505') {
                $motivo = 'A cidade (' . $cidade->getNome() . ') já está cadastrada e não pode ser duplicada. Tente fazer uma busca.';
            } else {
                $motivo = "Não foi possível incluir! Erro: " . $e->getMessage();
            }
            $mensagem = $motivo;
            throw new PDOException($mensagem);
        }
    }

    public function editar($cidade) {
        try {
            $stmt = $this->conexao->prepare("UPDATE cidade SET nome=?, estado_id=? WHERE id=?");
            $stmt->bindValue(1, $cidade->getNome());
            $stmt->bindValue(2, $cidade->getEstadoID());
            $stmt->bindValue(3, $cidade->getCidadeID());
            $stmt->execute();
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '23505') {
                $motivo = 'A cidade (' . $cidade->getNome() . ') já está cadastrada e não pode ser duplicada. Tente fazer uma busca.';
            } else {
                $motivo = "Não foi possível editar! Erro: " . $e->getMessage();
            }
            $mensagem = $motivo;
            throw new PDOException($mensagem);
        }
    }

    public function excluir($cidade) {
        try {
            $stmt = $this->conexao->prepare("DELETE FROM cidade WHERE id=?");
            $stmt->bindValue(1, $cidade->getCidadeID());
            $stmt->execute();
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '23503') {
                $motivo = 'Esta cidade está vinculada a outro processo!';
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
                    . "FROM vw_cidade "
                    . "WHERE LOWER(cidade_nome) LIKE LOWER(:busca) "
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
                . "FROM vw_cidade "
                . "WHERE LOWER(cidade_nome) LIKE LOWER(:busca)";
        $stmt = $this->conexao->prepare($query);
        $busca = "%" . $busca . "%";
        $stmt->bindValue(':busca', $busca, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function listarCidade($id) {
        try {
            $query = "SELECT * "
                    . "FROM vw_cidade "
                    . "WHERE cidade_id = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

}
