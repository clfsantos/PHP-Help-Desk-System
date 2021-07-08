<?php

class ReleaseDAO {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function inserir($release) {
        try {
            $query = "INSERT INTO spchamado_release (spchamado_release_produto, spchamado_release_num, spchamado_release_desc, spchamado_release_dt) "
                    . "VALUES (?,?,?,?)";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $release->getSpchamado_produto_id());
            $stmt->bindValue(2, $release->getSpchamado_release_num());
            $stmt->bindValue(3, $release->getSpchamado_release_desc());
            $stmt->bindValue(4, $release->getSpchamado_release_dt());
            $stmt->execute();
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '23505') {
                $motivo = 'A release (' . $release->getSpchamado_release_num() . ') já está cadastrada e não pode ser duplicada. Tente fazer uma busca.';
            } else {
                $motivo = "Não foi possível incluir! Erro: " . $e->getMessage();
            }
            $mensagem = $motivo;
            throw new PDOException($mensagem);
        }
    }

    public function atualizar($release) {
        try {
            $query = "UPDATE spchamado_release SET spchamado_release_produto=?, spchamado_release_num=?, spchamado_release_desc=?, spchamado_release_dt=? "
                    . "WHERE spchamado_release_id=?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $release->getSpchamado_produto_id());
            $stmt->bindValue(2, $release->getSpchamado_release_num());
            $stmt->bindValue(3, $release->getSpchamado_release_desc());
            $stmt->bindValue(4, $release->getSpchamado_release_dt());
            $stmt->bindValue(5, $release->getSpchamado_release_id());
            $stmt->execute();
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '23505') {
                $motivo = 'A release (' . $release->getSpchamado_release_num() . ') já está cadastrada e não pode ser duplicada. Tente fazer uma busca.';
            } else {
                $motivo = "Não foi possível editar! Erro: " . $e->getMessage();
            }
            $mensagem = $motivo;
            throw new PDOException($mensagem);
        }
    }

    public function excluir($release) {
        try {
            $stmt = $this->conexao->prepare("DELETE FROM spchamado_release WHERE spchamado_release_id=?");
            $stmt->bindValue(1, $release->getSpchamado_release_id());
            $stmt->execute();
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '23503') {
                $motivo = 'Esta release está vinculada a outro processo!';
            } else {
                $motivo = $e->getMessage();
            }
            $mensagem = 'Não foi possível excluir - ' . $motivo;
            throw new PDOException($mensagem);
        }
    }

    public function listar($busca, $offset, $rows, $sort, $order) {
        try {
            $query = "SELECT * FROM vw_spchamado_release "
                    . "WHERE LOWER(spchamado_release_num) LIKE LOWER(:busca) "
                    . "OR LOWER(spchamado_release_desc) LIKE LOWER(:busca) "
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
        $query = "SELECT count(spchamado_release_id) FROM vw_spchamado_release "
                . "WHERE LOWER(spchamado_release_num) LIKE LOWER(:busca) "
                . "OR LOWER(spchamado_release_desc) LIKE LOWER(:busca)";
        $stmt = $this->conexao->prepare($query);
        $busca = "%" . $busca . "%";
        $stmt->bindValue(':busca', $busca, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_NUM);
        return $row[0];
    }

    public function listarRelease($id) {
        try {
            $query = "SELECT * "
                    . "FROM vw_spchamado_release "
                    . "WHERE spchamado_release_id = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }
	
	public function releaseCombo($produtoID) {
        try {
            $query = "SELECT spchamado_release_id, spchamado_release_num FROM spchamado_release WHERE spchamado_release_produto = ? ORDER BY spchamado_release_id DESC";
            $stmt = $this->conexao->prepare($query);
			$stmt->bindValue(1, $produtoID, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }
}