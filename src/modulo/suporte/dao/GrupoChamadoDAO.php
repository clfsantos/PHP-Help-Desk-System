<?php

/**
 * Description of GrupoChamadoDAO
 *
 * @author cesantos
 */
class GrupoChamadoDAO {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function cadastrar($grupo, $produtos) {
        try {
            if (empty($produtos)) {
                throw new Exception("Selecione ao menos 1 produto para o grupo!", 105);
            }
            $this->conexao->beginTransaction();
            $query = "INSERT INTO spchamado_grupo (spchamado_grupo_desc) VALUES (?)";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $grupo->getSpchamado_grupo_desc(), PDO::PARAM_STR);
            $stmt->execute();
            $grupo_id = $this->conexao->lastInsertId('spchamado_grupo_spchamado_grupo_id_seq');
            foreach ($produtos as $produto) {
                $stmt = $this->conexao->prepare("INSERT INTO spchamado_produto_grupo (spchamado_produto_id, spchamado_grupo_id) VALUES (?,?)");
                $stmt->bindValue(1, $produto, PDO::PARAM_INT);
                $stmt->bindValue(2, $grupo_id, PDO::PARAM_INT);
                $stmt->execute();
            }
            $this->conexao->commit();
        } catch (PDOException $e) {
            $this->conexao->rollBack();
            if ($e->errorInfo[0] === '23505') {
                $motivo = 'O Grupo (' . $grupo->getSpchamado_grupo_desc() . ') já está cadastrado e não pode ser duplicado. Neste caso faça uma edição do grupo já existente e vincule ele a outro produto.';
            } else {
                $motivo = "Não foi possível incluir! Erro: " . $e->getMessage();
            }
            $mensagem = $motivo;
            throw new PDOException($mensagem);
        }
    }

    public function editar($grupo, $produtos) {
        try {
            if (empty($produtos)) {
                throw new Exception("Selecione ao menos 1 produto para o grupo!", 105);
            }
            $this->conexao->beginTransaction();
            $query = "UPDATE spchamado_grupo SET spchamado_grupo_desc=? "
                    . "WHERE spchamado_grupo_id = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $grupo->getSpchamado_grupo_desc(), PDO::PARAM_STR);
            $stmt->bindValue(2, $grupo->getSpchamado_grupo_id(), PDO::PARAM_INT);
            $stmt->execute();
            $stmt = $this->conexao->prepare("DELETE FROM spchamado_produto_grupo WHERE spchamado_grupo_id = ?");
            $stmt->bindValue(1, $grupo->getSpchamado_grupo_id(), PDO::PARAM_INT);
            $stmt->execute();
            foreach ($produtos as $produto) {
                $stmt = $this->conexao->prepare("INSERT INTO spchamado_produto_grupo (spchamado_produto_id, spchamado_grupo_id) VALUES (?,?)");
                $stmt->bindValue(1, $produto, PDO::PARAM_INT);
                $stmt->bindValue(2, $grupo->getSpchamado_grupo_id(), PDO::PARAM_INT);
                $stmt->execute();
            }
            $this->conexao->commit();
        } catch (PDOException $e) {
            $this->conexao->rollBack();
            if ($e->errorInfo[0] === '23505') {
                $motivo = 'O Grupo (' . $grupo->getSpchamado_grupo_desc() . ') já está cadastrado e não pode ser duplicado. Neste caso faça uma edição do grupo já existente e vincule ele a outro produto.';
            } else {
                $motivo = "Não foi possível editar! Erro: " . $e->getMessage();
            }
            $mensagem = $motivo;
            throw new PDOException($mensagem);
        }
    }

    public function excluir($grupo) {
        try {
            $this->conexao->beginTransaction();
            $stmt = $this->conexao->prepare("DELETE FROM spchamado_produto_grupo WHERE spchamado_grupo_id = ?");
            $stmt->bindValue(1, $grupo->getSpchamado_grupo_id(), PDO::PARAM_INT);
            $stmt->execute();
            $stmt = $this->conexao->prepare("DELETE FROM spchamado_grupo WHERE spchamado_grupo_id = ?");
            $stmt->bindValue(1, $grupo->getSpchamado_grupo_id(), PDO::PARAM_INT);
            $stmt->execute();
            $this->conexao->commit();
        } catch (PDOException $e) {
            $this->conexao->rollBack();
            throw new PDOException('Não foi possível excluir! - ' . $e->getMessage());
        }
    }

    public function listar($busca, $offset, $rows, $sort, $order) {
        try {
            $query = "SELECT * FROM spchamado_grupo "
                    . "WHERE LOWER(spchamado_grupo_desc) LIKE LOWER(:busca) "
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
        $query = "SELECT count(spchamado_grupo_id) FROM spchamado_grupo "
                . "WHERE LOWER(spchamado_grupo_desc) LIKE LOWER(:busca)";
        $stmt = $this->conexao->prepare($query);
        $busca = "%" . $busca . "%";
        $stmt->bindValue(':busca', $busca, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_NUM);
        return $row[0];
    }

    public function listarGrupo($id) {
        try {
            $query = "SELECT * "
                    . "FROM spchamado_grupo "
                    . "WHERE spchamado_grupo_id = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }
    
    public function listarGrupos() {
        try {
            $query = "SELECT * "
                    . "FROM spchamado_grupo "
                    . "ORDER BY spchamado_grupo_desc asc";
            $stmt = $this->conexao->query($query);
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar tudo! - ' . $e->getMessage());
        }
    }

    public function grupoLista($id) {
        try {
            $query = "SELECT spchamado_produto_id "
                    . "FROM spchamado_produto_grupo "
                    . "WHERE spchamado_grupo_id = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

    public function grupoChamadoCombo($produtoID) {
        try {
            $query = "SELECT spchamado_grupo_id, spchamado_grupo_desc "
                    . "FROM vw_spchamado_grupo "
                    . "WHERE spchamado_produto_id = ? "
                    . "ORDER BY spchamado_grupo_desc ASC";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $produtoID, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

}
