<?php

/**
 * Description of CidadeDAO
 *
 * @author Cesar
 */
class ContabilidadeDAO {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function cadastrar($contabilidade) {
        try {
            $stmt = $this->conexao->prepare("INSERT INTO contabilidade (contabilidade_cnpj,contabilidade_nome,contabilidade_contato,contabilidade_email,contabilidade_telefone,contabilidade_obs) VALUES (?,?,?,?,?,?)");
            $stmt->bindValue(1, $contabilidade->getCnpj());
            $stmt->bindValue(2, $contabilidade->getNome());
			$stmt->bindValue(3, $contabilidade->getContato());
			$stmt->bindValue(4, $contabilidade->getEmail());
			$stmt->bindValue(5, $contabilidade->getTelefone());
			$stmt->bindValue(6, $contabilidade->getObs());
            $stmt->execute();
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '23505') {
                $motivo = 'A contabilidade (' . $contabilidade->getNome() . ') já está cadastrada e não pode ser duplicada. Tente fazer uma busca.';
            } else {
                $motivo = "Não foi possível incluir! Erro: " . $e->getMessage();
            }
            $mensagem = $motivo;
            throw new PDOException($mensagem);
        }
    }

    public function editar($contabilidade) {
        try {
            $stmt = $this->conexao->prepare("UPDATE contabilidade SET contabilidade_cnpj=?,contabilidade_nome=?,contabilidade_contato=?,contabilidade_email=?,contabilidade_telefone=?,contabilidade_obs=? WHERE contabilidade_id=?");
            $stmt->bindValue(1, $contabilidade->getCnpj());
            $stmt->bindValue(2, $contabilidade->getNome());
			$stmt->bindValue(3, $contabilidade->getContato());
			$stmt->bindValue(4, $contabilidade->getEmail());
			$stmt->bindValue(5, $contabilidade->getTelefone());
			$stmt->bindValue(6, $contabilidade->getObs());
			$stmt->bindValue(7, $contabilidade->getContabilidadeID());
            $stmt->execute();
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '23505') {
                $motivo = 'A contabilidade (' . $contabilidade->getNome() . ') já está cadastrada e não pode ser duplicada. Tente fazer uma busca.';
            } else {
                $motivo = "Não foi possível editar! Erro: " . $e->getMessage();
            }
            $mensagem = $motivo;
            throw new PDOException($mensagem);
        }
    }

    public function excluir($contabilidade) {
        try {
            $stmt = $this->conexao->prepare("DELETE FROM contabilidade WHERE contabilidade_id=?");
            $stmt->bindValue(1, $contabilidade->getContabilidadeID());
            $stmt->execute();
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '23503') {
                $motivo = 'Esta contabilidade está vinculada a outro processo!';
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
                    . "FROM contabilidade "
                    . "WHERE LOWER(contabilidade_nome) LIKE LOWER(:busca) "
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
        $query = "SELECT count(contabilidade_id) "
                . "FROM contabilidade "
                . "WHERE LOWER(contabilidade_nome) LIKE LOWER(:busca)";
        $stmt = $this->conexao->prepare($query);
        $busca = "%" . $busca . "%";
        $stmt->bindValue(':busca', $busca, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_NUM);
        return $row[0];
    }

    public function listarContabilidade($id) {
        try {
            $query = "SELECT * "
                    . "FROM contabilidade "
                    . "WHERE contabilidade_id = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

}
